<html>
<head>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/watertank.js"></script>
    <script>
        var DISHAMOUNTINT = 0;
        var TOTAL = 0;
        var progressBar = null;
        function LoopData() {
            setTimeout(function () {
                renewData();
                LoopData();
            }, 1000)
        }

        function renewWaterTank(amount, total) {
            progressBar.waterTank({
                level: Math.floor(amount * 100 / total),
                color: '#656565',
            })
        }
        function renewData() {
            $.ajax({
                url: "DISHAMOUNTINT.php",
                context: document.body
            }).done(function (data) {
                var obj = jQuery.parseJSON(data);
                $("#data-field-msg").text(obj.msg);
                DISHAMOUNTINT = obj.number
                TOTAL = obj.total
                $("#data-field-total").text(TOTAL);
                $("#data-field-number").text(DISHAMOUNTINT);
                $("#data-field-finish").text(Math.floor(TOTAL-DISHAMOUNTINT));
                renewWaterTank(DISHAMOUNTINT, TOTAL)
            });
        }


        $(document).ready(function () {
            progressBar = $('.waterTankHere1').waterTank({
                width: 180,
                height: 360,
                color: 'skyblue',
                level: 0
            });
            LoopData()
        });
    </script>

</head>
<body>
<table style="width: 100%">
    <tr>
        <td style="">
            <h1>План на сегодня <span id="data-field-total"></span> </h1>
            <h2>За сегодня мы приготовили <span id="data-field-number"></span> блюд</h2>
            <h3>Осталось притготовить <span id="data-field-finish"></span> блюд</h3>
            <span style="font-size: smaller;color:red;" id="data-field-msg"></span>
        </td>
        <td>
            <div class="wrap">
                <div class="tank waterTankHere1"></div>
            </div>

        </td>
    </tr>
</table>


</body>
</html>
