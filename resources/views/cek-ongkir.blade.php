<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Ongkir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h2 class="text-center mt-3">Halaman Cek Ongkir</h2>

        <div class="w-100">
            <form action="" method="POST">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="mt-3">
                            <label for="origin_province">Asal Provinsi</label>
                            <select name="origin_province" id="origin_province" class="form-control" required>
                                <option value="">Pilih Provinsi Asal</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="origin">Asal Kota</label>
                            <select name="origin" id="origin" class="form-control" required
                                onchange="updatePostalCode('origin')">
                                <option value="">Pilih Kota Asal</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city['city_id'] }}"
                                        data-origin-postal-code="{{ $city['postal_code'] }}"
                                        data-province-id="{{ $city['province_id'] }}">
                                        {{ $city['city_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="origin_postal_code">Kode Pos</label>
                            <input type="number" name="origin_postal_code" id="origin_postal_code" readonly
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mt-3">
                            <label for="destination_province">Tujuan Provinsi</label>
                            <select name="destination_province" id="destination_province" class="form-control" required>
                                <option value="">Pilih Provinsi Tujuan</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="destination">Tujuan Kota</label>
                            <select name="destination" id="destination" class="form-control" required
                                onchange="updatePostalCode('destination')">
                                <option value="">Pilih Kota Tujuan</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city['city_id'] }}"
                                        data-destination-postal-code="{{ $city['postal_code'] }}"
                                        data-province-id="{{ $city['province_id'] }}">
                                        {{ $city['city_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="destination_postal_code">Kode Pos</label>
                            <input type="number" name="destination_postal_code" id="destination_postal_code" readonly
                                class="form-control">
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="weight">Berat Paket</label>
                    <input type="number" name="weight" id="weight" class="form-control" required>
                </div>
                <div class="mt-3">
                    <label for="courier">Kurir</label>
                    <select name="courier" id="courier" class="form-control" required>
                        <option value="">Pilih Jasa Pengiriman</option>
                        <option value="jne">JNE</option>
                        <option value="pos">POS</option>
                        <option value="tiki">TIKI</option>
                    </select>
                </div>
                <div class="mt-3">
                    <button type="submit" name="cekOngkir" class="btn btn-primary w-100">Cek Ongkir</button>
                </div>
            </form>

            <div class="mt-5">
                @if ($ongkir != '')
                    <h3>Rincian Ongkir</h3>

                    <h4>
                        <ul>
                            <li>Asal Kota: {{ $ongkir['origin_details']['city_name'] }}</li>
                            <li>Kota Tujuan: {{ $ongkir['destination_details']['city_name'] }}</li>
                            <li>Berat: {{ $ongkir['query']['weight'] }} Gram</li>
                        </ul>
                    </h4>
                    @foreach ($ongkir['results'] as $item)
                        <div>
                            <label for="name">Nama: {{ $item['name'] }}</label>
                            <p>Service: </p>
                            @foreach ($item['costs'] as $cost)
                                <div class="mb-3">
                                    <input type="radio" id="{{ $cost['service'] }}" name="service"> {{ $cost['service'] }}

                                    @foreach ($cost['cost'] as $price)
                                        <div class="mb-3">
                                            <label for="price">Harga: {{ $price['value'] }} (est:
                                                {{ $price['etd'] }} hari)</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </div>
</body>

</html>

<script>
    const originSelect = document.getElementById("origin");
    const originProvinceSelect = document.getElementById("origin_province");

    originProvinceSelect.addEventListener("change", () => {
        const selectedProvinceId = originProvinceSelect.value;

        // hide all options that don't match the selected province
        Array.from(originSelect.options).forEach(option => {
            const cityProvinceId = option.dataset.provinceId;
            option.hidden = (selectedProvinceId !== "" && selectedProvinceId !== cityProvinceId);
        });

        // reset the selected city
        originSelect.value = "";
    });

    const destinationSelect = document.getElementById("destination");
    const destinationProvinceSelect = document.getElementById("destination_province");

    destinationProvinceSelect.addEventListener("change", () => {
        const selectedProvinceId = destinationProvinceSelect.value;

        // hide all options that don't match the selected province
        Array.from(destinationSelect.options).forEach(option => {
            const cityProvinceId = option.dataset.provinceId;
            option.hidden = (selectedProvinceId !== "" && selectedProvinceId !== cityProvinceId);
        });

        // reset the selected city
        destinationSelect.value = "";
    });
</script>


<script>
    function updatePostalCode(type) {
        var select = document.getElementById(type);
        var postalCodeInput = document.getElementById(type + "_postal_code");
        var selectedOption = select.options[select.selectedIndex];
        postalCodeInput.value = selectedOption.getAttribute("data-" + type + "-postal-code");
    }
</script>
