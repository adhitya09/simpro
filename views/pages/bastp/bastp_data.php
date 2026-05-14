<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <tr>
        <th colspan="2" style="text-align: center; font-size: 18px;">BERITA ACARA SERAH TERIMA PEKERJAAN</th>
    </tr>
    <tr>
        <td style="width: 50%;"><strong>Title:</strong> {{title}}</td>
        <td style="width: 50%;"><strong>Last Update:</strong> {{last_update}}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Pada Hari Ini</strong> {{hari}}, <strong>Tanggal</strong> {{tanggal}} <strong>Bulan</strong> {{bulan}} <strong>Tahun</strong> {{tahun}}, telah dilaksanakan Pekerjaan {{kasus}} di lokasi {{lokasi}}.</td>
    </tr>
    <tr>
        <th colspan="2" style="text-align: center;">Detail Pekerjaan</th>
    </tr>
    <tr>
        <th>Uraian Pekerjaan</th>
        <td>{{uraian_pekerjaan}}</td>
    </tr>
    <tr>
        <th>Permasalahan</th>
        <td>{{permasalahan}}</td>
    </tr>
    <tr>
        <th>Proses Perbaikan</th>
        <td>{{proses_perbaikan}}</td>
    </tr>
    <tr>
        <th>Sesudah Perbaikan</th>
        <td>{{sesudah_perbaikan}}</td>
    </tr>
</table>

<!-- Page 2 - Tanda Tangan -->
<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin-top: 20px;">
    <tr>
        <th colspan="3" style="text-align: center; font-size: 18px;">Pengesahan</th>
    </tr>
    <tr>
        <td style="width: 33.3%; text-align: center;">
            <strong>Jr. Officer FS MOR VIII</strong>
            <br><br><br>
            {{jr_officer}}
        </td>
        <td style="width: 33.3%; text-align: center;">
            <strong>Sr. Spv. MOR VIII</strong>
            <br><br><br>
            {{sr_spv}}
        </td>
        <td style="width: 33.3%; text-align: center;">
            <strong>Fuel Terminal Manager Namlea</strong>
            <br><br><br>
            {{fuel_manager}}
        </td>
    </tr>
</table>

<style type="text/css">
    @media print {
        @page {
            size: landscape;
        }
    }
</style>
<script>
    window.print();
    setTimeout(function() {
        window.close();
    }, 100);
</script>