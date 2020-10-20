<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    @media print {
        .pagebreak { page-break-before: always; } /* page-break-after works, as well */
    }
    .header {
        position: fixed;
        top: 0;
    }
    .footer {
        position: fixed;
        bottom: 0;
    }
    </style>
</head>
<body onload="window.print()">
    {{-- <div class="header">...</div> --}}
    <div class="content">
        @foreach ($dosen as $item)
        <div class="media">
            <div class="media-body">
                {{-- <h3>Penelitian</h3> --}}
                <b style="font-size:25px">Research</b>
                <hr>
                <table class="table" border="0">
                    <tr>
                        <td width="70">Name</td>
                        <td>: {{$item->name}}</td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>: {{$item->nip}}</td>
                    </tr>
                    <tr>
                        <td>NIDN</td>
                        <td>: {{$item->nidn}}</td>
                    </tr>
                </table>
                <hr>
                <table style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Citations</th>
                            <th>Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($penelitian[$item->id] as $r)
                            {{-- @dd($r) --}}
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{!! htmlspecialchars_decode($r->judul) !!}<br><small>{{$r->penulis}} <br> {{$r->publis}}</small></td>
                                <td>{{$r->titasi}}</td>
                                <td>{{$r->tahun}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Citations</th>
                            <th>Year</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="pagebreak"></div>
        @endforeach
    </div>
    {{-- <div class="footer">...</div> --}}
    {{-- @dd($dosen) --}}
</body>
</html>