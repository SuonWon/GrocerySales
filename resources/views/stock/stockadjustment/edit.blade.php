<x-layout title="stock Adjustment edit">
    <h1>Hello Stock Adjustment Edit</h1>


    <button class="btn btn-sm btn-primary" onclick="postdata()">post data</button>
    
    <script type="text/javascript">

function postdata(){
            let data = {};
            let stockadjustmentDetailsArr = [];

            let stockadjustmentdetailsobject = {
                    LineNo: 0,
                    ItemCode: "SI-0001",
                    OldItemCode: "SI-0001",
                    Quantity: "100",
                    PackedUnit: "kg",
                    QtyPerUnit: "20",
                    TotalViss: "70",
                    OldTotalViss: "50",
                    UnitPrice: "10000",
                    Amount: "1000000",
                    AdjustType: 'minus',
                    OldAdjustType: 'add',
                    
            }

            stockadjustmentDetailsArr.push(stockadjustmentdetailsobject);

            data.AdjustmentDate = '2023-08-17';
            data.Warehouse = "WH-0001";
            data.OldWarehouse = "WH-0001";
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
            url: '/stockadjustment/update/AD-230800001',
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