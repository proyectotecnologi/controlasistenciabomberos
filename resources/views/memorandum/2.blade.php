<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memorandum - Policía Boliviana</title>
    <style>
        @page {
            size: letter;
            margin: 2cm;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            max-width: 21cm;
            margin: 0 auto;
            padding: 20px;
            background: white;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        
        .logo-section {
            width: 200px;
        }
        
        .logo {
            width: 120px;
            height: auto;
        }
        
        .institution-name {
            font-size: 9pt;
            text-align: center;
            margin-top: 5px;
            font-weight: bold;
        }
        
        .title-section {
            text-align: center;
            flex: 1;
        }
        
        .title {
            font-size: 20pt;
            font-weight: bold;
            letter-spacing: 8px;
            margin-bottom: 30px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .info-left {
            width: 48%;
        }
        
        .info-right {
            width: 48%;
        }
        
        .label {
            font-weight: bold;
            display: inline-block;
            min-width: 80px;
        }
        
        .value {
            display: inline-block;
            border-bottom: 1px dotted #000;
            min-width: 200px;
        }
        
        .separator {
            border: none;
            border-top: 2px solid #000;
            margin: 20px 0;
        }
        
        .content {
            text-align: justify;
            margin: 30px 0;
        }
        
        .greeting {
            margin: 20px 0;
        }
        
        .body-text {
            margin: 20px 0;
        }
        
        .highlight {
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .dates-highlight {
            background-color: #87CEEB;
            padding: 2px 4px;
            font-weight: bold;
        }
        
        .warning {
            margin: 20px 0;
            font-weight: bold;
        }
        
        .closing {
            margin: 30px 0;
            text-align: center;
        }
        
        .motto {
            font-style: italic;
            text-align: center;
            margin: 20px 0;
        }
        
        .signature-section {
            margin-top: 80px;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            width: 300px;
            margin: 0 auto 10px;
        }
        
        .signature-name {
            font-weight: bold;
            font-size: 11pt;
        }
        
        .signature-title {
            font-weight: bold;
            font-size: 11pt;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-style: italic;
            font-size: 11pt;
        }
        
        .initials {
            margin-top: 30px;
            font-size: 9pt;
        }
        
        .reference {
            text-align: right;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-section">
            <div style="text-align: center;">
                <div style="width: 120px; height: 120px; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                    <span style="font-size: 10pt; font-weight: bold;">LOGO<br>POLICÍA</span>
                </div>
                <div class="institution-name">
                    POLICÍA BOLIVIANA 22222222222<br>
                    DIRECCIÓN NACIONAL DE BOMBEROS<br>
                    <span style="font-size: 7pt;">DIRECCIÓN GDMB GENERAL DE BOMBEROS LA PAZ - PRESIDENCIA<br>SEC.E - 06 MISC</span>
                </div>
            </div>
        </div>
        
        <div class="title-section">
            <div class="title">MEMORANDUM</div>
            <div class="info-row">
                <div class="info-left">
                    <span class="label">No.:</span>
                    <span class="value">001/2025</span>
                </div>
                <div class="info-right">
                    <span class="label">Al Señor:</span><br>
                    <span class="value">Sgto. 2do. Juan José Flores Pérez</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-left">
                    <span class="label">Unidad:</span>
                    <span class="value">SEC. MOV. DE RR.HH.</span>
                </div>
                <div class="info-right">
                    <span class="label">CI.</span>
                    <span class="value">8334925 LP</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-left">
                    <span class="label">La Paz,</span>
                    <span class="value">17 de noviembre de 2025</span>
                </div>
                <div class="info-right">
                    <span class="value">Presente</span>
                </div>
            </div>
        </div>
    </div>
    
    <hr class="separator">
    
    <div class="reference">
        REF.: <span style="text-decoration: underline;">ARRESTO</span>
    </div>
    
    <div class="content">
        <div class="greeting">
            Señor Sargento Segundo:
        </div>
        
        <div class="body-text">
            Por disposición de este despacho, a la fecha es usted sancionado con 
            <span class="highlight">(LLAMADA DE ATENCIÓN ESCRITA Y ARRESTO DE 04 DÍAS)</span>, 
            por haber infringido el Cap. II, Art. 11, Numeral 12, de la Ley 101, Ley del Régimen Disciplinario 
            de la Policía Boliviana, que a la letra dice: <span class="highlight">"INASISTENCIA O ABANDONO 
            INJUSTIFICADO DE SUS FUNCIONES POR UN DÍA CON SANCIÓN DE CUATRO A CINCO DÍAS DE ARRESTO"</span>. 
            La presente sanción deberá cumplirse en fecha <span class="dates-highlight">martes 18, miércoles 19, 
            jueves 20, viernes 21 de noviembre</span> de la presente gestión, sanción que deberá cumplir en 
            la Dirección Nacional de Bomberos y registrarse en el libro de novedades.
        </div>
        
        <div class="warning">
            Advirtiéndole que de continuar con ese tipo de actitudes se asumirán medidas más drásticas 
            conforme a la Ley 101 de Régimen Disciplinario de la Policía Boliviana.
        </div>
        
        <div class="body-text">
            Asimismo, a la conclusión de dicha sanción deberá presentar los descargos correspondientes 
            a la Dirección Nacional de Bomberos.
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
    
    <!-- Botones de control (no se imprimen) -->
    <div class="no-print" style="position: fixed; top: 20px; right: 20px; background: white; padding: 15px; border: 2px solid #333; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.2);">
        <button onclick="window.print()" style="padding: 10px 20px; background: #0066cc; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14pt; margin-bottom: 10px; display: block; width: 100%;">
            🖨️ Imprimir / Generar PDF
        </button>
        <button onclick="llenarFormulario()" style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14pt; display: block; width: 100%;">
            📝 Llenar Datos
        </button>
    </div>
    
    <script>
        function llenarFormulario() {
            const numero = prompt("Número de memorándum:", "001/2025");
            const destinatario = prompt("Destinatario (Nombre completo):", "Sgto. 2do. Juan José Flores Pérez");
            const unidad = prompt("Unidad:", "SEC. MOV. DE RR.HH.");
            const ci = prompt("Cédula de Identidad:", "8334925 LP");
            const fecha = prompt("Fecha:", "17 de noviembre de 2025");
            const referencia = prompt("Referencia:", "ARRESTO");
            const motivo = prompt("Motivo de la sanción:", "INASISTENCIA O ABANDONO INJUSTIFICADO DE SUS FUNCIONES POR UN DÍA CON SANCIÓN DE CUATRO A CINCO DÍAS DE ARRESTO");
            const fechasCumplimiento = prompt("Fechas de cumplimiento:", "martes 18, miércoles 19, jueves 20, viernes 21 de noviembre");
            
            if (numero) document.querySelectorAll('.value')[0].textContent = numero;
            if (destinatario) document.querySelectorAll('.value')[1].textContent = destinatario;
            if (unidad) document.querySelectorAll('.value')[2].textContent = unidad;
            if (ci) document.querySelectorAll('.value')[3].textContent = ci;
            if (fecha) document.querySelectorAll('.value')[4].textContent = fecha;
            if (referencia) document.querySelector('.reference span').textContent = referencia;
        }
    </script>
</body>
</html>