<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Aspirasi Sarana Sekolah</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #667eea;
        }

        .header h1 {
            color: #667eea;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .info-section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fc;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .info-row {
            display: flex;
            margin-bottom: 10px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: bold;
            width: 150px;
            color: #333;
        }

        .info-value {
            color: #666;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            color: white;
        }

        .summary-card.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .summary-card.warning {
            background: linear-gradient(135deg, #f6c23e 0%, #f4b619 100%);
        }

        .summary-card.info {
            background: linear-gradient(135deg, #36b9cc 0%, #2c9faf 100%);
        }

        .summary-card.success {
            background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
        }

        .summary-card h3 {
            font-size: 32px;
            margin-bottom: 5px;
        }

        .summary-card p {
            font-size: 14px;
            opacity: 0.9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table thead {
            background: #667eea;
            color: white;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 13px;
        }

        table tbody tr:nth-child(even) {
            background: #f8f9fc;
        }

        table tbody tr:hover {
            background: #e9ecef;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }

        .status-belum {
            background: #fff3cd;
            color: #856404;
        }

        .status-proses {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-selesai {
            background: #d4edda;
            color: #155724;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
            text-align: right;
        }

        .signature {
            margin-top: 80px;
            text-align: center;
        }

        .signature p {
            margin-bottom: 60px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
        }

        .btn-actions {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fc;
            border-radius: 8px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 5px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-success {
            background: #1cc88a;
            color: white;
        }

        .btn-success:hover {
            background: #17a673;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                padding: 20px;
            }

            .btn-actions {
                display: none;
            }

            .summary-cards {
                page-break-inside: avoid;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Action Buttons -->
        <div class="btn-actions">
            <button onclick="window.print()" class="btn btn-primary">
                🖨️ Cetak Laporan
            </button>
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-success">
                🔙 Kembali
            </a>
        </div>

        <!-- Header -->
        <div class="header">
            <h1>📊 LAPORAN ASPIRASI SARANA SEKOLAH</h1>
            <p>Sistem Pengaduan Sarana dan Prasarana</p>
        </div>

        <!-- Info Section -->
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Periode Laporan:</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($tanggal_dari)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($tanggal_sampai)->format('d F Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kategori:</span>
                <span class="info-value">{{ $kategori }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">{{ $status }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Cetak:</span>
                <span class="info-value">{{ now()->format('d F Y, H:i') }} WIB</span>
            </div>
            <div class="info-row">
                <span class="info-label">Dicetak Oleh:</span>
                <span class="info-value">{{ Auth::guard('admin')->user()->nama }}</span>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card primary">
                <h3>{{ $aspirasis->count() }}</h3>
                <p>Total Aspirasi</p>
            </div>
            <div class="summary-card warning">
                <h3>{{ $aspirasis->where('status', 'Belum Diproses')->count() }}</h3>
                <p>Belum Diproses</p>
            </div>
            <div class="summary-card info">
                <h3>{{ $aspirasis->where('status', 'Sedang Diproses')->count() }}</h3>
                <p>Sedang Diproses</p>
            </div>
            <div class="summary-card success" style="grid-column: span 3;">
                <h3>{{ $aspirasis->where('status', 'Selesai')->count() }}</h3>
                <p>Selesai</p>
            </div>
        </div>

        <!-- Table Data -->
        @if($aspirasis->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Tanggal</th>
                    <th width="15%">Siswa</th>
                    <th width="25%">Judul Pengaduan</th>
                    <th width="12%">Kategori</th>
                    <th width="13%">Lokasi</th>
                    <th width="10%">Status</th>
                    <th width="10%">Umpan Balik</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aspirasis as $index => $aspirasi)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $aspirasi->tanggal_pengaduan->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $aspirasi->nama_siswa }}</strong><br>
                        <small style="color: #666;">{{ $aspirasi->kelas }}</small>
                    </td>
                    <td>{{ $aspirasi->judul_pengaduan }}</td>
                    <td>{{ $aspirasi->kategori->nama_kategori }}</td>
                    <td>{{ $aspirasi->lokasi ?? '-' }}</td>
                    <td>
                        @if($aspirasi->status == 'Belum Diproses')
                        <span class="status-badge status-belum">Belum Diproses</span>
                        @elseif($aspirasi->status == 'Sedang Diproses')
                        <span class="status-badge status-proses">Sedang Diproses</span>
                        @else
                        <span class="status-badge status-selesai">Selesai</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        {{ $aspirasi->umpanBaliks->count() }} balasan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <div style="font-size: 64px;">📭</div>
            <h3 style="color: #666; margin-top: 20px;">Tidak Ada Data</h3>
            <p>Tidak ada aspirasi yang sesuai dengan filter yang dipilih</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p style="margin-bottom: 5px;"><strong>Mengetahui,</strong></p>
            <p style="margin-bottom: 5px;">Administrator</p>
            
            <div class="signature">
                <p>_________________________</p>
                <p><strong>{{ Auth::guard
                
                ('admin')->user()->nama }}</strong></p>
                <p style="font-size: 12px; color: #666;">
                    {{ Auth::guard('admin')->user()->jabatan ?? 'Administrator Sistem' }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>
