[Q + Mongoose](https://gist.github.com/2660323), as an example of adapting Node code. Based on [this Stack Overflow question](http://stackoverflow.com/questions/10545087/how-to-use-module-q-to-refactoring-mongoose-code/).

[Q + node_redis](https://gist.github.com/2884566), as an example of adapting the node_redis operations to Q (Coffeescript)

[Flickr API Experiments](https://gist.github.com/2626708), as an example of adapting jQuery Ajax promises for a JSONP API. Uses deferreds, the `get` utility, `Q.all`, and chaining.

[Basic Chaining Example](https://gist.github.com/2431341), showing how promises compose. Also illustrates `Q.nfcall` as an alternative to using deferreds when working with Node.

[Simple Chaining Example](https://gist.github.com/jeffcogswell/8257755), briefly explains how chaining works.

[Promises in a UI Context](https://gist.github.com/1604916), a somewhat extensive and complicated "real world" example from @domenic's work at Barnes & Noble.com. Includes some helper functions to create alert/confirm/prompt dialogs that communicate their results via promises; adapts jQuery Ajax promises; and shows how to intercept and "re-throw" rejections at system boundaries.

[Using Array.reduce to make your own Q.all](https://gist.github.com/593065). This doesn’t work as well as Q.all or Q.allResolved, but I found it very instructive in discovering how promises can be composed.

[A very simplistic HTTP proxy](https://gist.github.com/593089)

[A simplistic HTTP "queue" application](https://gist.github.com/593082) Where POST puts a request’s *actively streaming* body into the queue and GET pipes the request’s body to the response’s body.

[How to adapt the XHR interface to an HTTP.read(url) that returns a Q](https://gist.github.com/593076)

[Control flow emulating "break" out of a loop of promises](https://gist.github.com/593066)

[Retry a some times with a delay between attempts](https://gist.github.com/593052)

[Old Narwhal code that illustrates functional composition of promises](https://gist.github.com/293354) But definitely would not run today without some modifications.

[XMLHttpRequest wrapped into a promise](https://gist.github.com/3099268)

[Concurrent Promises using `allResolved`, `spread` and `all`](https://github.com/basicallydan/q-examples/blob/master/wait-for-multiple-promises.js). Shows how one would go about having a bunch of functions that can execute together while another waits before executing, and how this could be done at the beginning of a chain, or during a chain. Plus, shows those concurrent promises piping through their values to the next function in the chain, together.

[Using promises as a cache and resource sharing feature](https://gist.github.com/wmertens/5830351). Shows how to store results from long-running functions so the result can be used by many callers. Useful for web services.

[Using promises as way to abstract the IndexedDb API into a usable interface](https://github.com/somecallmechief/oj-qdb). Wraps each async call to an IndexedDb instance/transaction/cursor or update with a promise. This allows the user to think only about the desired sequence of events, as opposed to the actual async sequence of events under the hood, without needing to worry about the order of operations.

[Q.js examples](https://gist.github.com/guptag/7205768) - Small snippets to understand various api methods in Q.js

[MapReduce example](https://gist.github.com/cpdean/8659630) - Using Q.all to merge the results of an arbitrary number of promises together.  One promise generates rows of data to be worked on concurrently, a second promise simulates additional work per row, and Q.all combines them at the end.
