<!doctype html>
<html>
<head>
    <title>Dates in JavaScript</title>
</head>
<body>
    <script src='/js/moment.js'></script>
    <script>
        var now = moment();

        // alert("The date is " + now.format("dddd, MMMM, Do YYYY, h:mm:ss a") + ".");
        console.log(now.format("dddd, MMMM, Do YYYY, h:mm:ss a"));

        console.log(moment().subtract('days', 1).fromNow());

        var codeup = moment('2-4-2014', 'MM-DD-YYYY');
        console.log(codeup.fromNow());
    </script>
</body>
</html>