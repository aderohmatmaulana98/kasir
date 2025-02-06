@extends('layout.base')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header"><h5>Form Belanja</h5></div>
                    <div class="card-body">
                        <form id="formBelanja">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Kode Barang</label>
                                <select name="barang" id="barang" class="form-select" required>
                                    <option value="">Pilih Kode Barang</option>
                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->kode_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" class="form-control" name="jumlah" id="jumlah" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header"><h5>Keranjang</h5></div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="keranjang"></tbody>
                        </table>
                        <h4>Total: <span id="totalBelanja">0</span></h4>
                        <input type="number" class="form-control" id="bayar" placeholder="Isi Pembayaran">
                        <h4>Kembali: <span id="kembalian">0</span></h4>
                        <button class="btn btn-primary" id="checkout">Selesai dan Cetak Struk</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TEMPLATE STRUK UNTUK PRINT -->
<div id="printStruk" style="display: none;">
    <div class="struk-container">
        <h2 class="toko">TOKO BIT</h2>
        <p><strong>Tgl :</strong> <span id="tanggal"></span></p>
        <p><strong>Kasir :</strong> Joe</p>

        <table class="struk-table">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="strukItems"></tbody>
        </table>

        <div class="total-container">
            <p><strong>Total:</strong> <span id="strukTotal"></span></p>
            <p><strong>Bayar:</strong> <span id="strukBayar"></span></p>
            <p><strong>Kembali:</strong> <span id="strukKembalian"></span></p>
        </div>
    </div>
</div>

<style>
/* Styling khusus untuk tampilan struk */
.struk-container {
    width: 300px;
    border: 1px solid black;
    padding: 10px;
    font-family: Arial, sans-serif;
}
.toko {
    text-align: center;
    font-size: 20px;
    font-weight: bold;
}
.struk-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
.struk-table th, .struk-table td {
    border: 1px solid black;
    padding: 5px;
    text-align: left;
}
.total-container {
    margin-top: 10px;
}
@media print {
    body * {
        visibility: hidden;
    }
    #printStruk, #printStruk * {
        visibility: visible;
    }
    #printStruk {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>

<script>
function updateKeranjang(keranjang) {
    let tbody = document.getElementById("keranjang");
    tbody.innerHTML = "";
    let total = 0;
    Object.keys(keranjang).forEach((id, index) => {
        let item = keranjang[id];
        total += item.subtotal;
        tbody.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.kode_barang}</td>
                <td>${item.nama_barang}</td>
                <td>${item.jumlah}</td>
                <td>${item.harga}</td>
                <td>${item.subtotal}</td>
                <td><button class="btn btn-danger" onclick="hapusBarang(${id})">Hapus</button></td>
            </tr>
        `;
    });
    document.getElementById("totalBelanja").innerText = total;
}

// Hitung kembalian otomatis saat input pembayaran berubah
document.getElementById("bayar").addEventListener("input", function () {
    let bayar = parseInt(this.value) || 0;
    let total = parseInt(document.getElementById("totalBelanja").innerText);
    let kembalian = bayar - total;
    document.getElementById("kembalian").innerText = kembalian < 0 ? "Pembayaran kurang!" : kembalian;
});

// Checkout dan cetak struk
document.getElementById("checkout").addEventListener("click", function () {
    let bayar = document.getElementById("bayar").value;

    fetch("{{ route('checkout') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ bayar })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            generateStruk(data);
            setTimeout(() => window.print(), 500); // Tunggu sebentar sebelum mencetak agar data terisi
        } else {
            alert(data.message);
        }
    });
});

function generateStruk(data) {
    document.getElementById("tanggal").innerText = new Date().toLocaleString();
    document.getElementById("strukTotal").innerText = data.total;
    document.getElementById("strukBayar").innerText = data.bayar;
    document.getElementById("strukKembalian").innerText = data.kembalian;

    let tbody = document.getElementById("strukItems");
    tbody.innerHTML = "";
    let keranjang = JSON.parse(localStorage.getItem("keranjang")) || {};
    Object.keys(keranjang).forEach(id => {
        let item = keranjang[id];
        tbody.innerHTML += `
            <tr>
                <td>${item.kode_barang}</td>
                <td>${item.nama_barang}</td>
                <td>${item.jumlah}</td>
                <td>${item.harga}</td>
                <td>${item.subtotal}</td>
            </tr>
        `;
    });

    document.getElementById("printStruk").style.display = "block";
}

// Simpan keranjang ke Local Storage agar bisa dipakai saat cetak struk
document.getElementById("formBelanja").addEventListener("submit", function (event) {
    event.preventDefault();
    let barang = document.getElementById("barang").value;
    let jumlah = document.getElementById("jumlah").value;

    fetch("{{ route('keranjang.tambah') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ barang, jumlah })
    })
    .then(response => response.json())
    .then(data => {
        localStorage.setItem("keranjang", JSON.stringify(data.keranjang));
        updateKeranjang(data.keranjang);
    });
});
</script>

@endsection
