<html>
<head>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script>
        function LoopData() {
            setTimeout(function () {
                renewData();
                LoopData();
            }, 1000)
        }

        function renewData() {
            $.ajax({
                url: "DISHAMOUNTINT.php",
                context: document.body
            }).done(function (data) {
                var obj = jQuery.parseJSON(data);
                $("#data-field-msg").text(obj.msg);
                $("#data-field-number").text(obj.number);
            });
        }

        $(document).ready(
            LoopData()
        );
    </script>
</head>
<body>
<h1>За сегодня мы приготовили <span id="data-field-number"></span></h1>

<span style="font-size: smaller;color:red;" id="data-field-msg"></span>
</body>
</html>
