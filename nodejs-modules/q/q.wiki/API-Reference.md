## Promise Methods

Most promise methods have "static" counterparts on the main `Q` object, which
will accept either a promise or a non-promise, and in the latter case create
a fulfilled promise first. For example, `Q.when(5, onFulfilled)` is equivalent
to `Q(5).then(onFulfilled)`. All others have static counterparts that
are named the same as the promise method.

Some methods are named the same as JavaScript reserved words, like `try`,
`catch`, and `finally`. This helps show the very clear parallel between standard
synchronous language constructs and asynchronous promise operations. However,
such use of words as property names is only supported as of the ECMAScript 5
edition of the JavaScript language, which isn't implemented in certain older
browsers like IE8, Safari 5, Android 2.2, or PhantomJS 1.8. If you're targeting
those browsers, and aren't using a language like CoffeeScript that takes care of
this for you, use their aliases instead, or escape them like `Q["try"](...)` or
`promise["catch"](...)`.

### Core Promise Methods

#### promise.then(onFulfilled, onRejected, onProgress)

The `then` method from the [Promises/A+ specification][], with an additional
progress handler.

[Promises/A+ specification]: http://promises-aplus.github.com/promises-spec/

#### promise.catch(onRejected)

_Alias:_ `promise.fail` (for non-ES5 browsers)

A sugar method, equivalent to `promise.then(undefined, onRejected)`.

#### promise.progress(onProgress)

A sugar method, equivalent to `promise.then(undefined, undefined, onProgress)`.

#### promise.finally(callback)

_Alias:_ `promise.fin` (for non-ES5 browsers)

Like a `finally` clause, allows you to observe either the fulfillment or
rejection of a promise, but to do so without modifying the final value. This is
useful for collecting resources regardless of whether a job succeeded, like
closing a database connection, shutting a server down, or deleting an unneeded
key from an object.

`finally` returns a promise, which will become resolved with the same
fulfillment value or rejection reason as `promise`. However, if `callback`
returns a promise, the resolution of the returned promise will be delayed until
the promise returned from `callback` is finished.

#### promise.done(onFulfilled, onRejected, onProgress)

Much like `then`, but with different behavior around unhandled rejection. If
there is an unhandled rejection, either because `promise` is rejected and no
`onRejected` callback was provided, or because `onFulfilled` or `onRejected`
threw an error or returned a rejected promise, the resulting rejection reason
is thrown as an exception in a future turn of the event loop.

This method should be used to terminate chains of promises that will not be
passed elsewhere. Since exceptions thrown in `then` callbacks are consumed and
transformed into rejections, exceptions at the end of the chain are easy to
accidentally, silently ignore. By arranging for the exception to be thrown in a
future turn of the event loop, so that it won't be caught, it causes an
`onerror` event on the browser `window`, or an `uncaughtException` event on
Node.js's `process` object.

Exceptions thrown by `done` will have long stack traces, if
`Q.longStackSupport` is set to `true`. If `Q.onerror` is set,
exceptions will be delivered there instead of thrown in a future turn.

*The Golden Rule of `done` vs. `then` usage is: either `return` your promise to
someone else, or if the chain ends with you, call `done` to terminate it.*

### Promise-for-Object Methods

#### promise.get(propertyName)

Returns a promise to get the named property of an object. Essentially equivalent
to

```js
promise.then(function (o) {
    return o[propertyName];
});
```

#### promise.post(methodName, args)

_Experimental Alias_: `promise.mapply`

Returns a promise for the result of calling the named method of an object with
the given array of arguments. The object itself is `this` in the function, just
like a synchronous method call. Essentially equivalent to

```js
promise.then(function (o) {
    return o[methodName].apply(o, args);
});
```

#### promise.invoke(methodName, ...args)

_Alias:_ `promise.send`

_Experimental Alias_: `promise.mcall`

Returns a promise for the result of calling the named method of an object with
the given variadic arguments. The object itself is `this` in the function, just
like a synchronous method call.

#### promise.keys()

Returns a promise for an array of the property names of an object. Essentially
equivalent to

```js
promise.then(function (o) {
    return Object.keys(o);
});
```

### Promise-for-Function Methods

#### promise.fbind(...args) *(deprecated)*

Returns a new function that calls a function asynchronously with the given
variadic arguments, and returns a promise. Notably, any synchronous return
values or thrown exceptions are transformed, respectively, into fulfillment
values or rejection reasons for the promise returned by this new function.

This method is especially useful in its static form for wrapping functions to
ensure that they are always asynchronous, and that any thrown exceptions
(intentional or accidental) are appropriately transformed into a returned
rejected promise. For example:

```js
var getUserData = Q.fbind(function (userName) {
    if (!userName) {
        throw new Error("userName must be truthy!");
    }

    if (localCache.has(userName)) {
        return localCache.get(userName);
    }

    return getUserFromCloud(userName);
});
```

#### promise.fapply(args)

Returns a promise for the result of calling a function, with the given array of
arguments. Essentially equivalent to

```js
promise.then(function (f) {
    return f.apply(undefined, args);
});
```

Note that this will result in the same return value/thrown exception translation
as explained above for `fbind`.

#### promise.fcall(...args)

_Static Alias:_ `Q.try` (ES5 browsers only)

Returns a promise for the result of calling a function, with the given variadic
arguments. Has the same return value/thrown exception translation as explained
above for `fbind`.

In its static form, it is aliased as `Q.try`, since it has semantics similar to
a `try` block (but handling both synchronous exceptions and asynchronous
rejections). This allows code like

```js
Q
.try(function () {
    if (!isConnectedToCloud()) {
        throw new Error("The cloud is down!");
    }

    return syncToCloud();
})
.catch(function (error) {
    console.error("Couldn't sync to the cloud", error);
});
```

### Promise-for-Array Methods

#### promise.all()

Returns a promise that is fulfilled with an array containing the fulfillment
value of each promise, or is rejected with the same rejection reason as the
first promise to be rejected.

This method is often used in its static form on arrays of promises, in order to
execute a number of operations concurrently and be notified when they all
succeed. For example:

```js
Q.all([saveToDisk(), saveToCloud()]).done(function () {
    console.log("Data saved!");
});
```

#### promise.allSettled()

Returns a promise that is fulfilled with an array of promise state snapshots,
but only after all the original promises have settled, i.e. become either
fulfilled or rejected.

This method is often used in its static form on arrays of promises, in order to
execute a number of operations concurrently and be notified when they all
finish, regardless of success or failure. For example:

```js
Q.allSettled([saveToDisk(), saveToCloud()]).spread(function (disk, cloud) {
    console.log("saved to disk:", disk.state === "fulfilled");
    console.log("saved to cloud:", cloud.state === "fulfilled");
}).done();
```

The state snapshots will be in the same form as those retrieved via
[`promise.inspect`](#promiseinspect), i.e. either
`{ state: "fulfilled", value: v }` or `{ state: "rejected", reason: r }`.

#### promise.spread(onFulfilled, onRejected)

Like `then`, but "spreads" the array into a variadic fulfillment handler. If any
of the promises in the array are rejected, instead calls `onRejected` with the
first rejected promise's rejection reason.

This is especially useful in conjunction with `all`, for example:

```js
Q.all([getFromDisk(), getFromCloud()]).spread(function (diskVal, cloudVal) {
    assert(diskVal === cloudVal);
}).done();
```

### Utility Methods

#### promise.thenResolve(value)

_No Static Counterpart_

A sugar method, equivalent to `promise.then(function () { return value; })`.

#### promise.thenReject(reason)

_No Static Counterpart_

A sugar method, equivalent to `promise.then(function () { throw reason; })`.

#### promise.timeout(ms, message)

Returns a promise that will have the same result as `promise`, except that if
`promise` is not fulfilled or rejected before `ms` milliseconds, the returned
promise will be rejected with an `Error` with the given `message`. If `message`
is not supplied, the message will be `"Timed out after " + ms + " ms"`.

#### promise.delay(ms)

Returns a promise that will have the same result as `promise`, but will only be
fulfilled or rejected after at least `ms` milliseconds have passed.

#### Q.delay(ms)

If the static version of `Q.delay` is passed only a single argument, it returns
a promise that will be fulfilled with `undefined` after at least `ms`
milliseconds have passed. (If it's called with two arguments, it uses the usual
static-counterpart translation, i.e. `Q.delay(value, ms)` is equivalent to
`Q(value).delay(ms)`.)

This is a convenient way to insert a delay into a promise chain, or even simply
to get a nicer syntax for `setTimeout`:

```js
Q.delay(150).then(doSomething);
```

### State Inspection Methods

#### promise.isFulfilled()

Returns whether a given promise is in the fulfilled state. When the static
version is used on non-promises, the result is always `true`.

#### promise.isRejected()

Returns whether a given promise is in the rejected state. When the static
version is used on non-promises, the result is always `false`.

#### promise.isPending()

Returns whether a given promise is in the pending state. When the static version
is used on non-promises, the result is always `false`.

#### promise.inspect()

Returns a "state snapshot" object, which will be in one of three forms:

- `{ state: "pending" }`
- `{ state: "fulfilled", value: <fulfllment value> }`
- `{ state: "rejected", reason: <rejection reason> }`

## Promise Creation

### Q.defer()

Returns a "deferred" object with a:

- `promise` property
- `resolve(value)` method
- `reject(reason)` method
- `notify(value)` method
- `makeNodeResolver()` method

The `resolve` and `reject` methods control the state of the `promise` property,
which you can hand out to others while keeping the authority to modify its state
to yourself. The `notify` method is for progress notification, and the
`makeNodeResolver` method is for interfacing with Node.js (see below).

In all cases where a promise is resolved (i.e. either fulfilled or rejected),
the resolution is permanent and cannot be reset. Attempting to call `resolve`,
`reject`, or `notify` if `promise` is already resolved will be a no-op.

Deferreds are cool because they separate the promise part from the resolver
part. So:

- You can give the promise to any number of consumers and all of them will
  observe the resolution independently. Because the capability of observing a
  promise is separated from the capability of resolving the promise, none of the
  recipients of the promise have the ability to "trick" other recipients with
  misinformation (or indeed interfere with them in any way).

- You can give the resolver to any number of producers and whoever resolves the
  promise first wins. Furthermore, none of the producers can observe that they
  lost unless you give them the promise part too.

#### deferred.resolve(value)

Calling `resolve` with a pending promise causes `promise` to wait on the passed
promise, becoming fulfilled with its fulfillment value or rejected with its
rejection reason (or staying pending forever, if the passed promise does).

Calling `resolve` with a rejected promise causes `promise` to be rejected with
the passed promise's rejection reason.

Calling `resolve` with a fulfilled promise causes `promise` to be fulfilled with
the passed promise's fulfillment value.

Calling `resolve` with a non-promise value causes `promise` to be fulfilled with
that value.

#### deferred.reject(reason)

Calling `reject` with a reason causes `promise` to be rejected with that reason.

#### deferred.notify(value)

Calling `notify` with a value causes `promise` to be notified of
progress with that value. That is, any `onProgress` handlers registered with
`promise` or promises derived from `promise` will be called with the progress
value.


### Q(value)

If `value` is a Q promise, returns the promise.

If `value` is a promise from another library it is coerced into a Q promise (where possible).

If `value` is not a promise, returns a promise that is fulfilled with `value`.

### Q.reject(reason)

Returns a promise that is rejected with `reason`.

### Q.Promise(resolver)

Synchronously calls `resolver(resolve, reject, notify)` and returns a promise
whose state is controlled by the functions passed to `resolver`. This is an
alternative promise-creation API that has the same power as the deferred
concept, but without introducing another conceptual entity.

If `resolver` throws an exception, the returned promise will be rejected with
that thrown exception as the rejection reason.

**note**: In the latest github, this method is called Q.Promise, but in the npm package version 0.9.7 (which is the latest npm package version at time of writing), the method is called Q.promise (lowercase vs uppercase p).

## Interfacing with Node.js Callbacks

Q provides a number of functions for interfacing with Node.js style
`(err, result)` callback APIs.

Several of these are usually used in their static form, and thus listed here as
such. Nevertheless, they also exist on each Q promise, in case you somehow have
a promise for a Node.js-style function or for an object with Node.js-style
methods.

Note that if a Node.js-style API calls back with more than one non-error
parameter (e.g. [`child_process.execFile`][cpef]), Q packages these into an
array as the promise's fulfillment value when doing the translation.

[cpef]: http://nodejs.org/api/child_process.html#child_process_child_process_execfile_file_args_options_callback

### Q.denodeify(nodeFunc, ...args)

_Alias_: `Q.nfbind`

Creates a promise-returning function from a Node.js-style function, optionally
binding it with the given variadic arguments. An example:

```js
var readFile = Q.denodeify(FS.readFile);

readFile("foo.txt", "utf-8").done(function (text) {

});
```

Note that if you have a *method* that uses the Node.js callback pattern, as
opposed to just a *function*, you will need to bind its `this` value before
passing it to `denodeify`, like so:

```js
var Kitty = mongoose.model("Kitty");
var findKitties = Q.denodeify(Kitty.find.bind(Kitty));
```

The better strategy for methods would be to use `Q.nbind`, as shown below.

### Q.nbind(nodeMethod, thisArg, ...args)

Creates a promise-returning function from a Node.js-style method, optionally
binding it with the given variadic arguments. An example:

```js
var Kitty = mongoose.model("Kitty");
var findKitties = Q.nbind(Kitty.find, Kitty);

findKitties({ cute: true }).done(function (theKitties) {

});
```

### Q.nfapply(nodeFunc, args)

Calls a Node.js-style function with the given array of arguments, returning a
promise that is fulfilled if the Node.js function calls back with a result, or
rejected if it calls back with an error (or throws one synchronously). An
example:

```js
Q.nfapply(FS.readFile, ["foo.txt", "utf-8"]).done(function (text) {
});
```

Note that this example only works because `FS.readFile` is a *function* exported
from a module, not a *method* on an object. For methods, e.g. `redisClient.get`,
you must bind the method to an instance before passing it to `Q.nfapply` (or,
generally, as an argument to any function call):

```js
Q.nfapply(redisClient.get.bind(redisClient), ["user:1:id"]).done(function (user) {
});
```

The better strategy for methods would be to use `Q.npost`, as shown below.

### Q.nfcall(func, ...args)

Calls a Node.js-style function with the given variadic arguments, returning a
promise that is fulfilled if the Node.js function calls back with a result, or
rejected if it calls back with an error (or throws one synchronously). An
example:

```js
Q.nfcall(FS.readFile, "foo.txt", "utf-8").done(function (text) {
});
```

The same warning about functions vs. methods applies for `nfcall` as it does for
`nfapply`. In this case, the better strategy would be to use `Q.ninvoke`.

### Q.npost(object, methodName, args)

_Deprecated Alias_: `Q.nmapply`

Calls a Node.js-style method with the given arguments array, returning a promise
that is fulfilled if the method calls back with a result, or rejected if it
calls back with an error (or throws one synchronously). An example:

```js
Q.npost(redisClient, "get", ["user:1:id"]).done(function (user) {
});
```

### Q.ninvoke(object, methodName, ...args)

_Alias:_ `Q.nsend`

_Deprecated Alias_: `Q.nmcall`

Calls a Node.js-style method with the given variadic arguments, returning a
promise that is fulfilled if the method calls back with a result, or rejected if
it calls back with an error (or throws one synchronously). An example:

```js
Q.ninvoke(redisClient, "get", "user:1:id").done(function (user) {
});
```

### promise.nodeify(callback)

If `callback` is a function, assumes it's a Node.js-style callback, and calls it
as either `callback(rejectionReason)` when/if `promise` becomes rejected, or
as `callback(null, fulfillmentValue)` when/if `promise` becomes fulfilled. If
`callback` is not a function, simply returns `promise`.

This method is useful for creating dual promise/callback APIs, i.e. APIs that
return promises but also accept Node.js-style callbacks. For example:

```js
function createUser(userName, userData, callback) {
    return database.ensureUserNameNotTaken(userName)
    .then(function () {
        return database.saveUserData(userName, userData);
    })
    .nodeify(callback);
}
```

### deferred.makeNodeResolver()

Returns a function suitable for passing to a Node.js API. That is, it has a
signature `(err, result)` and will reject `deferred.promise` with `err` if
`err` is given, or fulfill it with `result` if that is given.

## Generators

_This functionality is experimental._

### Q.async(generatorFunction)

This is an experimental tool for converting a generator function into a deferred
function.  This has the potential of reducing nested callbacks in engines that
support `yield`. See [the generators example][] for further information.

[the generators example]: https://github.com/kriskowal/q/tree/master/examples/async-generators

### Q.spawn(generatorFunction)

This immediately runs a generator function, and forwards any uncaught errors to
`Q.onerror`. An uncaught error is deemed to occur if the function returns a
rejected promise. Note that this automatically occurs if the generator function
throws an error, e.g. by `yield`ing on a promise that becomes rejected without surrounding that code with a `try`/`catch`:

```js
Q.spawn(function* () {
    // If `createUser` returns a rejected promise, the rejection reason will
    // reach `Q.onerror`.
    var user = yield createUser();
    showUserInUI(user);
});
```

## Error Handling and Tracking

### Q.onerror

A settable property that will intercept any uncaught errors that would otherwise
be thrown in the next tick of the event loop, usually as a result of `done`.
Can be useful for getting the full stack trace of an error in browsers, which is
not usually possible with `window.onerror`.

### Q.getUnhandledReasons()

Gets an array of reasons belonging to rejected promises that currently have not
been handled, i.e. no `onRejected` callbacks have been called for them, they
haven't been chained off of, etc. Generally these represent potentially-"lost"
errors, so this array should be empty except possibly at times when you are
passing a rejected promise around asynchronously so that someone can handle the
rejection later.

### Q.stopUnhandledRejectionTracking()

Turns off unhandled rejection tracking, which provides a slight efficiency
boost if you don't find that debug information helpful. It also prevents Q from
printing any unhandled rejection reasons upon process exit in Node.js.

### Q.resetUnhandledRejections()

Resets Q's internal tracking of unhandled rejections, but keeps unhandled
rejection tracking on. This method is exposed mainly for testing and diagnostic
purposes, where you may have accumulated some unhandled rejections but want to
re-start with a clean slate.

## Other

### Q.isPromise(value)

Returns whether the given value is a Q promise.

### Q.isPromiseAlike(value)

Returns whether the given value is a promise (i.e. it's an object with a `then` function).

### Q.promised(func)

Creates a new version of `func` that accepts any combination of promise and
non-promise values, converting them to their fulfillment values before calling
the original `func`. The returned version also always returns a promise: if
`func` does a `return` or `throw`, then `Q.promised(func)` will return
fulfilled or rejected promise, respectively.

This can be useful for creating functions that accept either promises or
non-promise values, and for ensuring that the function always returns a promise
even in the face of unintentional thrown exceptions.

### Q.longStackSupport

A settable property that lets you turn on long stack trace support. If turned
on, "stack jumps" will be tracked across asynchronous promise operations, so
that if an uncaught error is thrown by `done` or a rejection reason's `stack`
property is inspected in a rejection callback, a long stack trace is produced.

## Custom Messaging API (Advanced)

The `Q` promise constructor establishes the basic API for performing operations
on objects: "get", "put", "del", "post", "apply", and "keys". This set of
"operators" can be extended by creating promises that respond to messages with
other operator names, and by sending corresponding messages to those promises.

### promise.dispatch(operator, args)

Sends an arbitrary message to a promise, with the given array of arguments.

Care should be taken not to introduce control-flow hazards and security holes
when forwarding messages to promises. The functions above, particularly `then`,
are carefully crafted to prevent a poorly crafted or malicious promise from
breaking the invariants like not applying callbacks multiple times or in the
same turn of the event loop.