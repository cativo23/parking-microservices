<h1 style="text-align: center">
    Residents Pending Payments
</h1>
<div class="container">
    <table style="width: 100%; border-collapse: collapse; height: 54px;" border="1">
        <tbody>
        <tr style="height: 18px;">
            <td style="width: 25%; height: 18px; text-align: center;">License Plate</td>
            <td style="width: 25%; height: 18px; text-align: center;">Parking Time (min.)</td>
            <td style="width: 25%; height: 18px; text-align: center;">Total ($)</td>
        </tr>
        @foreach ($registrations as $value)
        <tr style="height: 18px;">
            <td style="width: 25%; height: 18px; text-align: center;">{{ $value['license_plate'] }}</td>
            <td style="width: 25%; height: 18px; text-align: center;">{{ $value['parking_time'] }}</td>
            <td style="width: 25%; height: 18px; text-align: center;">{{ $value['total'] }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
