<?php
 
$dataPoints = array( 
	array("y" => 53, "label" => "Dress Casual" ),
	array("y" => 19, "label" => "Dress Pesta" ),
	array("y" => 13, "label" => "Kemeja Panjang" ),
	array("y" => 25, "label" => "Kemeja Pendek" ),
	array("y" => 28, "label" => "Jeans" ),
	array("y" => 6, "label" => "Atasan Jas" ),
	array("y" => 48, "label" => "Gamis" ),
	array("y" => 23, "label" => "Koko" )
);
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <link rel="stylesheet" href="css/laporan.css">
    <script>
        window.onload = function() {
        
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            backgroundColor: "transparent",
            title:{
                text: "Penjualan Model",
                fontColor: "#ffffff"
            },
            axisY: {
                labelFontColor: "#08ffad",
                titleFontColor: "#ffffff"
            },
            axisX: {
                labelFontColor: "#08ffad",
                labelFontSize: 11,
                labelWrap: true,
                labelAngle: -45,
                labelMaxWidth: 50,
            },
            data: [{
                type: "column",
                color:"#ffffff",
                yValueFormatString: "#,##0.##",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }],
            toolTip: {
                backgroundColor: "#475581",
                fontColor: "#ffffff",
                borderColor: "#ffffff"
            }
        });
        chart.render();
        
        }
    </script>
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="container">
    <h1>Laporan</h1>
    <div class="parent">
        <div class="div1">
            <div class="chart">
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            </div>
            </div>
        <div class="div2">
            <div class="circle">
                <p>42<br>Selesai</p>
            </div>
        </div>
        <div class="div3">
            <h3>DEADLINE TERDEKAT</h3>
            <div class="wrapper">
                <div class="hari">
                    8
                </div>
                <div class="tersisa">
                    <p>Hari<br>Tersisa</p>
                </div>
                <div class="pemilik">
                    <h4>IS823</h4>
                    <p>Mas Amba</p>
                    <p>Kemeja Panjang</p>
                </div>
            </div>
        </div>
        <div class="div4">
            <h2>Last Order</h2>
            <ul>
                <li class="item">
                    <div class="info">
                        Ibu Kus
                        <div class="status">
                            <span class="dot"></span>
                            <span class="status-text">Pemotongan</span>
                        </div>
                    </div>
                    <div class="date">3 Juni 2025</div>
                </li>
                <li class="item">
                    <div class="info">
                        Ibu Kus
                        <div class="status">
                            <span class="dot"></span>
                            <span class="status-text">Pemotongan</span>
                        </div>
                    </div>
                    <div class="date">3 Juni 2025</div>
                </li>
                <li class="item">
                    <div class="info">
                        Ibu Kus
                        <div class="status">
                            <span class="dot"></span>
                            <span class="status-text">Pemotongan</span>
                        </div>
                    </div>
                    <div class="date">3 Juni 2025</div>
                </li>
            </ul>
        </div>
    </div>
    </div>

    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>