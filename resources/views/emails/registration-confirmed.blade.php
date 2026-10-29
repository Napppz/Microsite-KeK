<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Akreditasi Delegasi & E-Tiket</title>
</head>
<body style="margin: 0; padding: 0; background-color: #0b1118; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #ffffff;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #0b1118; padding: 30px 15px;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table role="presentation" width="100%" style="max-width: 620px; background-color: #101820; border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 4px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);" cellspacing="0" cellpadding="0" border="0">
                    
                    <!-- Top Gold Line -->
                    <tr>
                        <td style="height: 4px; background-color: #E9A443; line-height: 4px; font-size: 0;">&nbsp;</td>
                    </tr>

                    <!-- Header -->
                    <tr>
                        <td style="padding: 32px 32px 20px 32px; text-align: center; background-color: #0e161f; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                            <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; color: #E9A443; margin-bottom: 8px;">
                                Konfirmasi Akreditasi Resmi
                            </div>
                            <h1 style="margin: 0 0 6px 0; font-size: 24px; font-weight: 600; color: #ffffff; letter-spacing: 0.5px;">
                                {{ config('event.name', 'KEK Business Forum') }} {{ $registration->event->year ?? '2025' }}
                            </h1>
                            <div style="font-size: 12px; color: rgba(255, 255, 255, 0.65);">
                                {{ config('event.ministry', 'Kementerian Koordinator Bidang Perekonomian RI') }}
                            </div>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 32px 32px 20px 32px;">
                            <p style="margin: 0 0 16px 0; font-size: 15px; line-height: 1.6; color: rgba(255, 255, 255, 0.9);">
                                Yth. <strong>{{ $registration->full_name }}</strong>,
                            </p>
                            <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: rgba(255, 255, 255, 0.75);">
                                Registrasi permohonan akreditasi delegasi Anda untuk menghadiri <strong>{{ config('event.name') }} {{ $registration->event->year ?? '2025' }}</strong> telah berhasil diproses. E-Tiket dan kartu akreditasi digital resmi Anda telah diterbitkan.
                            </p>

                            <!-- Ticket Card (High Contrast White Container) -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #ffffff; border-radius: 6px; margin-bottom: 24px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                <tr>
                                    <td style="padding: 24px; text-align: center;">
                                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #183B5B; margin-bottom: 4px;">
                                            Official Delegation Pass — E-Badge & Pass Akses Acara
                                        </div>
                                        <div style="font-size: 20px; font-weight: 800; color: #101820; font-family: monospace; letter-spacing: 1px; margin-bottom: 16px;">
                                            {{ $ticket->ticket_number }}
                                        </div>

                                        <!-- QR Code Container -->
                                        <div style="display: inline-block; padding: 12px; background-color: #ffffff; border: 2px solid #e2e8f0; border-radius: 4px; margin-bottom: 16px;">
                                            <img src="{{ $qrDataUri }}" alt="QR Code Tiket" width="180" height="180" style="display: block; margin: 0 auto; border: 0;" />
                                        </div>

                                        <div style="font-size: 11px; color: #64748b; line-height: 1.5; max-width: 380px; margin: 0 auto;">
                                            Scan QR token unik ini di meja registrasi kedatangan. Token tidak mengandung informasi identitas pribadi terbuka.
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 20px;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size: 12px; color: #334155;">
                                            <tr>
                                                <td style="padding: 4px 0; color: #64748b; width: 40%;">Nomor Registrasi:</td>
                                                <td style="padding: 4px 0; font-weight: 600; font-family: monospace; color: #0f172a;">{{ $registration->registration_code }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 4px 0; color: #64748b;">Nama Delegasi:</td>
                                                <td style="padding: 4px 0; font-weight: 600; color: #0f172a;">{{ $registration->full_name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 4px 0; color: #64748b;">Instansi / Jabatan:</td>
                                                <td style="padding: 4px 0; font-weight: 600; color: #0f172a;">{{ $registration->company_name }} ({{ $registration->position }})</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 4px 0; color: #64748b;">Kategori Delegasi:</td>
                                                <td style="padding: 4px 0; font-weight: 600; text-transform: uppercase; color: #183B5B;">{{ $registration->participation_category }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom: 24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{!! $signedTicketUrl !!}" target="_blank" style="display: inline-block; background-color: #E9A443; color: #101820; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 14px 28px; text-decoration: none; border-radius: 3px; box-shadow: 0 4px 8px rgba(233, 164, 67, 0.3);">
                                            Buka E-Tiket Digital Resmi
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Event Details & Check-In Guide -->
                            <div style="background-color: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 4px; padding: 18px; margin-bottom: 24px;">
                                <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #E9A443; margin-bottom: 10px;">
                                    Informasi Kehadiran & Tata Tertib Protokoler:
                                </div>
                                <ul style="margin: 0; padding-left: 20px; font-size: 12px; line-height: 1.8; color: rgba(255, 255, 255, 0.75);">
                                    <li><strong>Jadwal Pelaksanaan:</strong> {{ config('event.dates') }} ({{ config('event.time_schedule') }})</li>
                                    <li><strong>Lokasi / Venue:</strong> {{ config('event.venue_name') }} — {{ config('event.venue_address') }}</li>
                                    <li><strong>Prosedur Check-in:</strong> Tunjukkan kode QR di atas atau kartu digital melalui tautan resmi kepada staf protokoler di pintu masuk delegasi.</li>
                                    <li><strong>Verifikasi Identitas:</strong> Mohon membawa kartu identitas resmi (KTP / Paspor / ID Perusahaan) yang sesuai dengan nama terdaftar.</li>
                                </ul>
                            </div>

                            <p style="margin: 0; font-size: 12px; line-height: 1.5; color: rgba(255, 255, 255, 0.5);">
                                Jika Anda membutuhkan bantuan protokoler atau mengalami kendala, hubungi sekretariat panitia melalui meja informasi resmi.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 24px 32px; background-color: #090e14; border-top: 1px solid rgba(255, 255, 255, 0.08); text-align: center;">
                            <div style="font-size: 11px; color: rgba(255, 255, 255, 0.5); line-height: 1.6;">
                                {{ config('event.organizer') }}<br>
                                {{ config('event.ministry') }}<br>
                                &copy; {{ date('Y') }} {{ config('event.name') }}. Seluruh hak cipta dilindungi undang-undang.
                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
