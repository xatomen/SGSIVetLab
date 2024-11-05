<div class="container">
    <style>
        .content{
            width: 350px;
            /* position: absolute; */
            /* top: 50%; */
            /* left: 50%; */
            /* transform: translate(-50%,-50%); */
            background-color: #fff;
            padding: 20px;
            text-align: center;
        }
        #barcode{
            box-shadow: 0 0 20px rgba(0,139,253,0.25);
            width: 300px;
            margin: 30px 0px 30px 0px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.3/JsBarcode.all.min.js"></script>
    <div class="content card">
        <input type="text" id="text">
        <svg id="barcode"></svg>
        <button id="btn">Generate</button>
    </div>

    <script>
        document.getElementById("btn").addEventListener("click", () => {
        let text = document.getElementById("text").value;
        JsBarcode("#barcode", text);
        });
    </script>
</div>