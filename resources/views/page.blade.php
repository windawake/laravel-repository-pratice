<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
    <button id="export">导出</button>
    <script>
        $("#export").on('click', function(){
            var settings = {
            "url": "/frontend/reports/bonus",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Accept": "",
                "Authorization": "bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMTMxOjgyMDBcL2Zyb250ZW5kXC91c2VyXC9sb2dpbiIsImlhdCI6MTU2ODQ3NzExNywiZXhwIjoxNTY4NDg0MzE3LCJuYmYiOjE1Njg0NzcxMTcsImp0aSI6IlBSTWI4RThMbm9jQXlxbWMiLCJzdWIiOjE0LCJwcnYiOiJjNWYwYWQ2NWE1OTJjYzg0MzJmODNkODBhNGUyMjY5MDkwNDNmOTUyIn0.U0LVLgv_MEea6nUmTZVxf-0qtZPwFjP1J-NLu6hrdRY",
                "request_id": "1568476910-9aec1589-0409-41de-9dc2-6c2e4ba57239",
                "Content-Type": "application/json"
            },
            "data": "{\"request_action\":\"download\"}",
            };

            $.ajax(settings).done(function (response) {
                var aaaa = "data:text/csv;charset=utf-8,\ufeff" + response;
                var link = document.createElement("a");
                link.setAttribute("href", aaaa);
                
                var filename = "test";
                link.setAttribute("download", filename + ".csv");
                link.click();
            });
        })
        
</script>
</body>
</html>
