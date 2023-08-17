<x-layout title="stock adjustment">
    <h1>Hello Stock Adjustment</h1>

    <button class="btn btn-sm btn-primary" onclick="postdata()">post data</button>
    
    <script type="text/javascript">

        function postdata(){
            let data = {};
            let stockadjustmentDetailsArr = [];

            let stockAdjustmentDetailsObject = {
                    LineNo: 0,
                    ItemCode: "SI-0001",
                    Quantity: "100",
                    PackedUnit: "kg",
                    QtyPerUnit: "20",
                    TotalViss: "50",
                    UnitPrice: "10000",
                    Amount: "1000000",
                    AdjustType: "add"
            }

            stockadjustmentDetailsArr.push(stockAdjustmentDetailsObject);

            data.AdjustmentDate = '2023-08-17';
            data.Warehouse = "WH-0001";
            data.Remark = "hello";
            data.Status = "O";

            

            data.stockadjustmentdetails = stockadjustmentDetailsArr;

            data = JSON.stringify(data);

            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });

            $.ajax({
            url: '/stockadjustment/add',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {

                console.log(response);

                if (response.message == "good") {

                    console.log(response.message);
                    
                }

            },
            error: function(error) {
                console.log('no');
                console.log(error.responseText);
                res = JSON.parse(error.responseText);
                console.log(res);
            }
        });

        }
    </script>
</x-layout>