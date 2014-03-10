Welcome! Q works well alongside jQuery’s promise system, but the patterns are a
little bit different.

In Q, promises are better suited to error handling, and maintaining the parallel
between normal synchronous code and asynchronous promise code. jQuery's promises
do not try to make this parallel, and thus jQuery and Q diverge in several
design decisions which we outline here.


## Exception Handling

jQuery's `then` does not handle exceptions thrown inside the handlers passed to
`then`; instead, it lets them bubble, usually reaching `window.onerror`. Q, and
Promises/A+ generally, instead maintains a strong correspondence: `return` means
resolve the promise; `throw` means reject the promise. So code like this:

~~~js
var promise2 = promise1.then(function () {
    throw new Error("boom!");
});
~~~

will result in `promise2` being rejected in Q, whereas in jQuery, the thrown
exception will be un-handleable by user code, instead bubbling to
`window.onerror`.

The Promises/A+ model is much more powerful, as it maintains the parallel
between synchronous code and asynchronous code. It allows you to reuse
synchronous functions, like `JSON.parse`, that may throw, inside your
asynchronous promise handlers. Those synchronous failures, when introduced into
an asynchronous workflow, will create asynchronous failures, which you can then
handle asynchronously inside the promise model. In this way, using Q gives you
back control over your exceptions.

However, you do have to be careful with the Promises/A+ model. Since Q lets you
handle your own exceptions, you need to not forget about them, letting them be
trapped in rejected promises forever, with nobody to look at those rejections!
The easiest way to do this is to follow the advice [from the Q readme][advice]:
always end a promise chain by either `return`ing the promise to the caller, or
calling `.done()` to signify that any unhandled rejections are no longer your
responsibility, and should be thrown.

[advice]: https://github.com/kriskowal/q#the-end


## Converting JQuery Promises to Q

Converting from jQuery promises to Q is easy! Simply pass the promise into the Q function:

~~~js
return Q(jQuery.ajax({
    url: "foobar.html", 
    type: "GET"
})).then(function (data) {
    // on success
}, function (xhr) {
    // on failure
});

// Similar to jQuery's "complete" callback: return "xhr" regardless of success or failure
return Q.promise(function (resolve) {
    jQuery.ajax({
        url: "foobar.html",
        type: "GET"
    }).then(function (data, textStatus, jqXHR) {
        delete jqXHR.then; // treat xhr as a non-promise
        resolve(jqXHR);
    }, function (jqXHR, textStatus, errorThrown) {
        delete jqXHR.then; // treat xhr as a non-promise
        resolve(jqXHR);
    });
});
~~~

## Chaining

jQuery's `done` and `fail` methods are consistent with jQuery's internal ideas
about chaining, but inconsistent with common usage of promises. In jQuery,
chaining functions usually return the `this` object of the call so you can
build up lots of handlers on a single object. With promises, though, it is far
more common that you will only need to set up handlers on the promise once,
modeling the linear, non-branching synchronous control flow of `return`, `try`,
`catch`, and `finally`—but asynchronously.

All of Q’s methods on promises return a new promise, not `this`. The new promise
gets resolved with the return value of either the fulfillment handler or the
rejection handler. Only one of these functions will be called, and each function
can only return a value or throw an exception. If a handler throws an exception,
the promise gets rejected. If a handler returns a promise, it gets “forwarded”
to the promise that was originally returned.

The practical upside of this is that in jQuery, the methods `done` and `fail`
are often used to attach handlers by taking advantage of their `this`-returning
nature. Thus, where in Q you might write

~~~js
qPromise.then(success, failure);
~~~

with jQuery promises people often write

~~~js
jQueryPromise.done(success).fail(failure);
~~~

In Q, the first pattern is correct. `fail` is an alias for `catch`, which, just
like `then`, will return a new promise. And `done` is something else entirely.
It is essentially a version of `then` that signifies the end of the chain. It
will return `undefined`, and any errors thrown in its handlers will be
re-thrown, since there is no promise returned for it to forward them to.

With Q, you *can* attach multiple handlers to a single promise, but you have to
reuse a reference to the promise instead of chaining.

~~~js
var promiseB = qPromiseA.then(makeB);
var promiseC = qPromiseA.then(makeC);
qPromiseA.catch(handleFailureA).done();
~~~

This creates a fork in your control flow, where the fulfillment of `qPromiseA`
will kick off two parallel and independent jobs to resolve promises B and C
using the return values of `makeB` and `makeC`, but the rejection of `qPromiseA`
will cause an attempt to recover with `handleFailureA`, and if that fails,
throw an exception to the user.


## Asynchrony

jQuery's promises are not guaranteed to be asynchronous. Thus, code like

~~~js
jQueryPromise.then(function () {
    myObject.state = "X";
});

myObject.state = "A";
~~~

could either end up with your object in state `"X"`, or in state `"A"`,
depending on whether `jQueryPromise` was an asynchronous promise or a
synchronous promise. This introduces control-flow hazards and race conditions
into your code, as you cannot expect any given execution order for jQuery
promise-based code.

In Q, and indeed in all Promises/A+ compliant libraries, promises are guaranteed
to be asynchronous. So code of the form

~~~js
qPromise.then(function () {
    myObject.state = "X";
});

myObject.state = "A";
~~~

will always end up with your object in state `"X"`.


## Single vs. Multiple Values

In Q, all promises can have either a single value, if fulfilled, or a single
reason, if rejected. This parallels how a synchronous function can either
return a single value, or throw a single exception.

This is different from jQuery, which chooses to forgo the sync/async parallel,
and instead commonly pass multiple values to its promise handlers. So if you
are used to writing code like

~~~js
$.ajax(...).then(function (data, status, xhr) {
    console.log(data, status, xhr);
});
~~~

when transitioning to Q you should treat promise-returning functions like normal
synchronous functions, in that you should assume they only return a single
object, perhaps like so:

~~~js
qAjax(...).then(function (result) {
    console.log(result.data, result.status, result.xhr);
});
~~~

If you are using the "multiple return values" feature for something that should
actually be treated as an array, then you can just use an array. Q even provides
the `spread` function to make this a bit easier:

~~~js
$.when(jQueryPromise1, jQueryPromise2).then(function (result1, result2) {
    
});

// becomes

Q.all([qPromise1, qPromise2]).spread(function (result1, result2) {
    
});
~~~


## Deferreds, Promises, Resolvers

jQuery balances the principle of least-authority differently than Q. Q
separates authority by default and jQuery provides a mechanism for separating
authority.

Both Q and jQuery provide a deferred object that hosts the authorities of
observing state and changing state. In Q, the deferred has a `promise`
property that is the sole interface for observing state. The `resolve` and
`reject` functions change state. Only the `promise` has the promise API in Q.
In jQuery, the `$.Deferred` object is both the promise and the deferred, but it
provides a `promise()` *function* that can either return the promise part of
the API, or put the promise methods on another object.

~~~js
function foo() {
    var result = Q.defer();
    result.resolve(10);
    return result.promise;
}
~~~

~~~js
function foo() {
    var result = $.Deferred();
    result.resolve(10);
    return result; // or
    return result.promise();
}
~~~

Q is less prone to accidental gifting of excess authority. It’s easier to give
than to take back.


## Context

Q does not track the context object that goes with a fulfilled value since this
cannot be expressed with a return value or thrown exception in the synchronous
parallel. As such, if you want a particular `this` bound in your handler
functions, you will need to bind it yourself or bind it to another value in
scope. It is not the resolving party's job to decide what `this` the handler
should be called with.

~~~js
var self = this;
promise.then(function () {
    // use self
});
~~~

~~~js
promise.then(function () {
    // use this
}.bind(this));
~~~


## Terminology

Q uses the [Promises/A+](http://promisesaplus.com/) terminology, wherein
promises can be in one of three states:

- **Pending**, wherein the promise does not yet have a value;
- **Fulfilled**, wherein the promise has a value;
- **Rejected**, wherein the promise does not have a value but does have a
  reason why it couldn't give you that value.

Additionally, Promises/A+ uses the word "settled" to mean "either fulfilled or
rejected."

jQuery promises have states that are somewhat analogous to these. The biggest
difference is that they use "resolved" where Promises/A+ says "fulfilled." In
Q, "resolved" actually means "has been locked in to one course of action"; a
promise can be in any of the three states, but also be resolved. For more
details on this see ["States and Fates"][states-and-fates].

[states-and-fates]: https://github.com/domenic/promises-unwrapping/blob/master/docs/states-and-fates.md


## Reference

<table>
    <thead>
        <tr>
            <th>jQuery</th>
            <th>Q</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>then</code></td>
            <td><code>then</code></td>
            <td>Q's <code>then</code>, and in fact all of its methods, have
                different exception-handling behavior, as described above.</td>
        </tr>
        <tr>
            <td><code>done</code></td>
            <td><code>then</code></td>
            <td><code>then</code> does not support multiple handlers; use
                multiple calls to <code>then</code> to attach them.</td>
        </tr>
        <tr>
            <td><code>fail</code></td>
            <td><code>catch</code></td>
            <td><code>catch</code> does not support multiple handlers; use
                multiple calls to <code>catch</code> to attach them.</td>
        </tr>
        <tr>
            <td><code>progress</code></td>
            <td><code>progress</code></td>
            <td><code>progress</code> does not support multiple handlers; use
                multiple calls to <code>progress</code> to attach them.</td>
        </tr>
        <tr>
            <td><code>always</code></td>
            <td><code>finally</code></td>
            <td><code>finally</code> has semantics that better parallel
                synchronous <code>try</code>-<code>finally</code>, instead of
                simply passing the same handler for both fulfillment and
                rejection.</td>
        </tr>
        <tr>
            <td><code>isResolved</code></td>
            <td><code>isFulfilled</code></td>
            <td>As noted above, jQuery uses the term "resolved" where
                Promises/A+ libraries use "fulfilled."</td>
        </tr>
        <tr>
            <td><code>isRejected</code></td>
            <td><code>isRejected</code></td>
            <td></td>
        </tr>
        <tr>
            <td><code>resolve</code></td>
            <td><code>deferred.resolve</code></td>
            <td>If you pass a promise to Q's <code>resolve</code>, then
                <code>deferred.promise</code> will follow the passed promise's
                state.</td>
        </tr>
        <tr>
            <td><code>resolveWith</code></td>
            <td>(none)</td>
            <td>Q does not allow the deferred to control the <code>this</code>
                of the promise handlers.</td>
        </tr>
        <tr>
            <td><code>reject</code></td>
            <td><code>deferred.reject</code></td>
            <td></td>
        </tr>
        <tr>
            <td><code>rejectWith</code></td>
            <td>(none)</td>
            <td>Q does not allow the deferred to control the <code>this</code>
                of the promise handlers.</td>
        </tr>
        <tr>
            <td><code>notify</code></td>
            <td><code>deferred.notify</code></td>
            <td></td>
        </tr>
        <tr>
            <td><code>resolveWith</code></td>
            <td>(none)</td>
            <td>Q does not allow the deferred to control the <code>this</code>
                of the promise handlers.</td>
        </tr>
        <tr>
            <td><code>deferred.promise</code> (method)</td>
            <td><code>deferred.promise</code> (property)</td>
            <td>You *must* get the <code>promise</code> part of the deferred;
                the deferred does not have the promise API.</td>
        </tr>
        <tr>
            <td><code>state</code></td>
            <td><code>inspect</code></td>
            <td><code>inspect</code> returns state snapshot objects in the form
                <code>{ state, value|reason }</code>.</td>
        </tr>
        <tr>
            <td><code>$.when</code></td>
            <td><code>Q</code> or <code>Q.all</code></td>
            <td>Use the <code>Q</code> function to turn the non-promise values
                into promises, or pass an array to <code>Q.all</code> to get
                back a promise for an array of the results.</td>
        </tr>
    </tbody>
</table>
