Mark Miller and Kris Kowal (yours truly) are frequently experimenting and converging around Mark’s [Concurrency Strawman](http://wiki.ecmascript.org/doku.php?id=strawman:concurrency) for a future version of the ECMAScript specification. This is an analysis of the present (March 2012) differences between Q and the standard proposal.

-   High order bit: This Q implementation reflects nearly every “static” ``Q.*(promise, …)`` function as an equivalent ``promise.*(…)`` method.  The only difference is that the static varieties *always* coerce the promise: values to fulfilled promises, thenables to wrapped promises, promiseSendables stay the same.  I realize as I’m writing this that I should unconditionally wrap the given promise to guarantee the interface of the returned object, even in the face of malice.  Giving promiseSendables a pass is a hazard. 

-   **Resolve:** Q does not support the proposed ``Q()`` function.  The proposed behavior is equivalent to the present ``Q.resolve()`` as proposed by @domenic and the legacy (still supported) ``Q.ref()`` as implemented in the original Waterken ``ref_send`` on which Q is based.  This ``Q`` implementation provides ``call`` and ``apply`` methods for sending messages to promised functions. These would conflict with ``call`` and ``apply`` on the ``Function.prototype``.

-   **Reject:** The ``Q.reject(error)`` function is implemented as proposed. I may eventually restrict the domain of the error to exception objects, or at least restrict strings, so that I can make some stronger guarantees to error handlers.

-   **isPromise:** The ``Q.isPromise`` function is implemented as specified, as well as ``Q.isFulfilled`` (which tolerates non-promise values), ``Q.isRejected``, ``Q.isResolved`` as well as these functions as promise methods except **``promise.isPromise()``.

-    **When/Then:** Q does support ``promise.when()`` in the interest of compatibility with this specification, but the ``promise.then()`` interface has won over the JavaScript community.  Q promises’ ``then`` method supports the CommonJS/A specification as proposed by Kris Zyp. ``Q.resolve(promise)`` is also able to “assimilate” other objects that have ``then`` methods as long as they are designed to call the given ``fulfilled`` or ``rejected`` functions; a property supported by Dojo promises and even the errant jQuery promises.  ``Q.resolve(promise)`` ignores the return-value of the ``then``, ensuring that the assimilated promise is in-fact a ``Q`` promise with all of the provided methods and behaviors.  I recall that a colleague of Mark Miller found a reason why the method should be named ``when`` instead of ``then``, but I do not recall the argument and it has not surfaced a problem in my practice.

     The ``end`` function is implemented as specified, and also implemented as ``Q.end(promise)``.

     In addition, this implementation provides some shorthands: ``promise.fail(errback)`` and ``promise.fin(finback)``.

     The ``fail`` function is a shorthand for passing only an errback to ``then``.  I may add support for a default noop errback.  Presently, not providing an errback is the same as providing neither an errback nor a callback, which just forwards the resolution of the previous promise: which is to say it is an utterly useless pattern.

    The ``finback`` receives no arguments, its fulfillment value is ignored — the resolution of the promise gets forwarded.  However, if the finback returns a promise, the resolution of that promise may delay the forwarding.  If the finback returns a promise that is eventually rejected, or if it throws an exception, the new error overrides the original resolution.

-    **Get/Put/Post:** The ``get``, ``put``, and ``post`` are all implemented as proposed.  The proposed ``delete`` is called ``del`` in ``Q``, but experimentally aliased as ``delete``.

    The proposed ``promise.send`` is equivalent to the implemented ``promise.invoke``.  I have reserved ``promise.send`` for sending messages to promises, but I have not documented it and the signature may be some combination of ``operator``, ``resolve``, and variadic arguments, where operators are like ``"get"`` and ``"del"``. I may change the ``"when"`` operator to ``"then"`` and ``"del"`` to ``"delete"``.  I think there is some flexibility here still since it is only substantial to the protocol spoken between the Q and Q-Comm libraries.  My operator names differ from Tyler Close’s original Waterken ref_send in that they are all lower-case.

-    **Nearer Value:** The proposed ``Q.nearer(promise)`` is almost equivalent to the implemented ``promise.valueOf()``. If the promise is fulfilled, ``promise.valueOf()`` returns the fulfilled value.  If the promise is or has forwarded to a deferred promise, it returns most recently deferred promise (the specification says that it should return the original promise, but I presume this is not intentional). For rejected promises, ``promise.valueOf()`` returns a sentinel object with ``{rejectedPromise: true, reason: {}}``; I intend to alter the implementation to meet the specification in this regard.

-    **All:** The proposed ``Q.all(...args)`` is implemented as non-variadic ``Q.all(args)``.  In the absence of rest arguments, we recover the cost of adding brackets in some places in not having to wrap promises like ``Q.all.apply(null, promises)`` in other cases.  I’ve recently added ``Q.allResolved(promises)`` and ``promiseForPromises.allResolved()``.

-    **Delay:** I implemented ``Q.delay`` slightly differently.  The proposal is ``Q.delay(millis, answer)``.  To be consistent with other methods implemented both on the ``Q`` object and on the promise object, this implementation puts the “answer” first, so the argument forms are: ``Q.delay(answer, millis)``, ``promise.delay(millis)``.  For convenience, I recognize that when only one argument is provided (as indicated by ``arguments.length``), the answer is undefined, ``Q.delay(millies).then(function () {})``.

-    **Async:** I have implemented ``Q.async`` as proposed, including support for ``ReturnValue`` errors as proposed for Harmony but not yet implemented in FireFox’s SpiderMonkey.

-    **Remotes and Vats:** I have not implemented ``makeFar``, ``makeRemote``, ``race``, or ``join`` in this library.  I have left these to the purview of Q-Comm.  I would like to implement vats and ``where`` (or ``there`` to be consistent with ``then``) in WebWorkers and Node subprocesses uses ES5-Lab’s SES initializer.

-    **Others:*** I also have not implemented ``memoize`` in this library since I do not want to entrain a ``WeakMap`` shim.

I have also begun experimenting with the following keyword aliases:

-    ``finally`` for ``fin``
-    ``catch`` for ``fail`` (``when(promise, void 0, callback)``)
-    ``try`` for ``call`` (e.g., ``Q.try(f).catch(f).finally(f).end()``)
-    ``delete`` for ``del``
