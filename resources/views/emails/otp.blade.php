<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de verificación</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; -webkit-font-smoothing: antialiased; color: #333333;">
    
    <!-- Contenedor Principal -->
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f6f9; padding: 40px 10px;">
        <tr>
            <td align="center">
                
                <!-- Tarjeta del Correo -->
                <table role="presentation" width="100%" max-width="500" cellspacing="0" cellpadding="0" border="0" style="max-width: 500px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); overflow: hidden; border: 1px solid #e2e8f0;">
                    
                    <!-- Encabezado / Branding -->
                    <tr>
                        <td align="center" style="background-color: #2563eb; padding: 28px 20px;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 600; letter-spacing: 0.5px;">
                                Código de Verificación
                            </h1>
                        </td>
                    </tr>

                    <!-- Cuerpo del Mensaje -->
                    <tr>
                        <td style="padding: 32px 28px;">
                            <p style="margin: 0 0 16px 0; font-size: 16px; line-height: 1.5; color: #1e293b;">
                                Hola <strong>{{ $user->name }}</strong>,
                            </p>
                            <p style="margin: 0 0 24px 0; font-size: 15px; line-height: 1.5; color: #475569;">
                                Has solicitado un código de acceso para tu cuenta. Utiliza la siguiente clave temporal para completar tu verificación:
                            </p>

                            <!-- Bloque Destacado del OTP -->
                            <div style="background-color: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 8px; padding: 20px; text-align: center; margin-bottom: 24px;">
                                <span style="display: block; font-size: 32px; font-weight: 800; letter-spacing: 6px; color: #1e40af; font-family: 'Courier New', Courier, monospace;">
                                    {{ $otp }}
                                </span>
                            </div>

                            <!-- Alerta de Tiempo -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom: 24px;">
                                <tr>
                                    <td style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 12px 16px; border-radius: 4px;">
                                        <p style="margin: 0; font-size: 13px; color: #92400e; font-weight: 500;">
                                            ⏱️ Este código expira en <strong>5 minutos</strong>.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #64748b;">
                                Si no solicitaste este código, puedes ignorar este mensaje de forma segura. Tu cuenta permanece protegida.
                            </p>
                        </td>
                    </tr>

                    <!-- Pie de página -->
                    <tr>
                        <td align="center" style="background-color: #f8fafc; padding: 16px 20px; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0; font-size: 12px; color: #94a3b8;">
                                Este es un correo automático, por favor no respondas a este mensaje.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>