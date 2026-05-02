<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memorandum Leve - Policía Boliviana</title>
    <style>
        @page {
            size: letter;
            margin: 1.5cm 2cm;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
            max-width: 21cm;
            margin: 0 auto;
            padding: 10px;
            background: white;
        }
        
        .header {
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        
        .header-top {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        
        .logo-section {
            display: table-cell;
            width: 180px;
            vertical-align: middle;
        }
        
        .logo-container {
            width: 180px;
            height: 100px;
        }
        
        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .title-section {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
        
        .title {
            font-size: 18pt;
            font-weight: bold;
            letter-spacing: 8px;
            margin: 0;
        }
        
        .info-section {
            margin-top: 10px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-table td {
            padding: 4px 10px;
            vertical-align: top;
        }
        
        .info-left {
            width: 48%;
            border-right: 2px solid #000;
        }
        
        .info-right {
            width: 48%;
            padding-left: 15px;
        }
        
        .info-line {
            margin-bottom: 6px;
            line-height: 1.3;
        }
        
        .label {
            font-weight: bold;
            display: inline;
        }
        
        .value {
            display: inline;
            border-bottom: 1px dotted #000;
            padding: 0 5px;
        }
        
        .separator {
            border: none;
            border-top: 2px solid #000;
            margin: 8px 0 15px 0;
        }
        
        .content {
            text-align: justify;
            margin: 20px 0;
        }
        
        .greeting {
            margin: 15px 0;
        }
        
        .body-text {
            margin: 15px 0;
        }
        
        .highlight {
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .warning {
            margin: 15px 0;
            font-weight: bold;
        }
        
        .closing {
            margin: 20px 0;
            text-align: center;
        }
        
        .motto {
            font-style: italic;
            text-align: center;
            margin: 15px 0;
        }
        
        .signature-section {
            margin-top: 60px;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            width: 300px;
            margin: 0 auto 10px;
        }
        
        .signature-name {
            font-weight: bold;
            font-size: 10pt;
        }
        
        .signature-title {
            font-weight: bold;
            font-size: 10pt;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-style: italic;
            font-size: 10pt;
        }
        
        .initials {
            margin-top: 25px;
            font-size: 8pt;
        }
        
        .reference {
            text-align: right;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-top">
            <div class="logo-section">
                <div class="logo-container">
                    <img src="{{ public_path('pdf/logo_policia.png') }}" alt="">
                </div>
            </div>
            
            <div class="title-section">
                <div class="title">MEMORÁNDUM</div>
            </div>
        </div>
        
        <div class="info-section">
            <table class="info-table">
                <tr>
                    <td class="info-left">
                        <div class="info-line">
                            <span class="label">No.:</span>
                            <span class="value">{{ $numero_memorandum ?? '001/2025' }}</span>
                        </div>
                        <div class="info-line">
                            <span class="label">Unidad:</span>
                            <span class="value">{{ $miembro->division_o_dependencia ?? 'SEC. MOV. DE RR.HH.' }}</span>
                        </div>
                        <div class="info-line">
                            <span class="label">La Paz,</span>
                            <span class="value">{{ $fecha_actual }}</span>
                        </div>
                    </td>
                    <td class="info-right">
                        <div class="info-line">
                            <span class="label">Al Señor:</span>
                            <span class="value">{{ $miembro->grado }} {{ $miembro->nombre_apellido }}</span>
                        </div>
                        <div class="info-line">
                            <span class="label">CI.:</span>
                            <span class="value">{{ $miembro->ci }}</span>
                        </div>
                        <div class="info-line">
                            <span class="value">Presente</span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
    <hr class="separator">
    
    <div class="reference">
        REF.: <span style="text-decoration: underline;">{{ $referencia ?? 'LLAMADA DE ATENCIÓN' }}</span>
    </div>
    
    <div class="content">
        <div class="greeting">
            Señor {{ $miembro->grado }}:
        </div>
        
        <div class="body-text">
            Por disposición de este despacho, a la fecha es usted sancionado con 
            <span class="highlight">(LLAMADA DE ATENCIÓN ESCRITA Y ARRESTO DE 04 DÍAS)</span>, 
            por haber infringido el Cap. II, Art. 11, Numeral 12, de la Ley 101, Ley del Régimen Disciplinario 
            de la Policía Boliviana, que a la letra dice: <span class="highlight">"INASISTENCIA O ABANDONO INJUSTIFICADO DE SUS FUNCIONES POR UN DÍA CON SANCIÓN DE CUATRO A CINCO DÍAS DE ARRESTO"</span>. 
            La presente sanción corresponde a {{ $mes_sancion }} de {{ $anio_sancion }} por tener 
            <span class="highlight">{{ $faltas }} falta(s)</span> registrada(s).
        </div>
        
        <div class="warning">
            Advirtiéndole que de continuar con ese tipo de actitudes se asumirán medidas más drásticas 
            conforme a la Ley 101 de Régimen Disciplinario de la Policía Boliviana.
        </div>
        
        <div class="body-text">
            Asimismo, a la conclusión de dicha sanción deberá presentar los descargos correspondientes a la Dirección Nacional de Bomberos.
        </div>
        
        <div class="closing">
            Con este motivo, saludo a usted, atentamente.
        </div>
        
        <div class="motto">
            "DISCIPLINA, VALOR Y VOCACIÓN DE SERVICIO"
        </div>
    </div>
    
    <div class="signature-section">
        <div class="signature-line"></div>
        <div class="signature-name">Cnl. DESP. Gonzalo Enrique Velasco Michel.</div>
        <div class="signature-title">DIRECTOR NACIONAL DE BOMBEROS</div>
    </div>
    
    <div class="footer">
        "2025 BICENTENARIO DE BOLIVIA"
    </div>
    
    <div class="initials">
        GEVM/mrlz<br>
        DC/mrlz
    </div>
</body>
</html>