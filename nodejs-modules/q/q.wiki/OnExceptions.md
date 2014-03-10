There’s an interesting thing about error handling with promises: it is
easy to isolate error sources.  Consider the following anti-pattern.  It is
common for a programmer to capture more exceptions than they intend.

~~~javascript
var info, processed;
try {
    info = JSON.parse(json);
    processed = process(info);
} catch (exception) {
    console.log("Information JSON malformed.");
}
~~~

There is a tension here.  The programmer only wants to proceed if an exception
is not thrown, but they also only want to catch the syntax error.  The
following, far more verbose, example appropriately isolates the syntax error.

~~~javascript
var info, processed, erred;
try {
    info = JSON.parse(json);
} catch (exception) {
    console.log("Information JSON malformed.");
    erred = true;
}
if (!erred) {
    processed = process(info);
}
~~~

With our promise library, error isolation is inherent to the system.  The error
handler applies only to the given promise and does not catch an exception
thrown in the fulfillment handler.

~~~javascript
var processed = Q.fcall(function () {
    return JSON.parse(json);
})
.then(function (info) {
    return process(info);
}, function (exception) {
    console.log("Information JSON malformed.");
})
~~~

Perhaps an idle musing, but this kind of elegance might be achived with a new
keyword, like ``then``, that would permit catch or resume semantics.

~~~javascript
var info, processed;
try {
    info = JSON.parse(json);
} catch (exception) {
    console.log("Information JSON malformed.");
} then {
    processed = process(info);
} catch (exception) {
    console.log("Error processing information.");
}
// ...
~~~

