<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Morbiditas Rawat Inap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div class="container mt-5 mb-5">
        <h1>Laporan Morbiditas Rawat Inap</h1>
        <button onclick="exportToExcel('tableekspor')" class="btn btn-success">Export Data</button>
        <div class="mt-3">
            <table border="1" class="text-center table-bordered" id="tableekspor">
                <thead>
                    <tr>
                        <th rowspan="2">Kode ICD</th>
                        <th rowspan="2">Diagnosa Penyakit</th>
                        @foreach ($ageGroups as $group)
                            <th colspan="2">{{ $group }} Tahun</th>
                        @endforeach
                        <th colspan="3">Jumlah Pasien Keluar Hidup dan Mati Menurut Jenis Kelamin</th>
                        <th colspan="3">Jumlah Pasien Keluar Mati</th>
                    </tr>
                    <tr>
                        @foreach ($ageGroups as $group)
                            <th>L</th>
                            <th>P</th>
                        @endforeach
                        <th>L</th>
                        <th>P</th>
                        <th>Total</th>
                        <th>L</th>
                        <th>P</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item['code_icd'] }}</td>
                            <td>{{ $item['long_desc'] }}</td>
                            @foreach ($ageGroups as $group)
                                <td>{{ $item['groups'][$group]['L'] ?? 0 }}</td>
                                <td>{{ $item['groups'][$group]['P'] ?? 0 }}</td>
                            @endforeach
                            {{-- Jumlah Pasien Keluar Hidup dan Mati Menurut Jenis Kelamin --}}
                            <td>{{ $item['total']['L'] }}</td>
                            <td>{{ $item['total']['P'] }}</td>
                            <td>{{ $item['total']['L'] + $item['total']['P'] }}</td>
                            {{-- Jumlah Pasien Keluar Mati --}}
                            <td>{{ $item['krs_meninggal']['L'] }}</td>
                            <td>{{ $item['krs_meninggal']['P'] }}</td>
                            <td>{{ $item['krs_meninggal']['L'] + $item['krs_meninggal']['P'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
    <script type="text/javascript">
        function exportToExcel(tableID, filename = 'Laporan Morbiditas Rawat Inap') {
            var downloadurl;
            var dataFileType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTMLData = tableSelect.outerHTML.replace(/ /g, '%20');

            filename = filename ? filename + '.xls' : 'export_excel_data.xls';
            downloadurl = document.createElement("a");

            document.body.appendChild(downloadurl);

            // if (navigator.msSaveOrOpenBlob) {
            //     var blob = new Blob(['\ufeff', tableHTMLData], {
            //         type: dataFileType
            //     });
            //     navigator.msSaveOrOpenBlob(blob, filename);
            // } else {
                // Create a link to the file
                downloadurl.href = 'data:' + dataFileType + ', ' + tableHTMLData;

                // Setting the file name
                downloadurl.download = filename;

                //triggering the function
                downloadurl.click();
            // }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js"
        integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+" crossorigin="anonymous">
    </script>
</body>

</html>
