function notifyAll(fnSms, fnEmail) {
setTimeout(function () {
    console.log("one");
    fnSms();
    setTimeout(function () {
        console.log("two");
        setTimeout(function () {
            console.log("three");
            fnEmail();
        }, 1000);
    }, 1000);
}, 1000);
}
notifyAll(
    function () {
        console.log("Sms send ..");
    },
    function () {
        console.log("email send ..");
    }
);
console.log("End of script"); 