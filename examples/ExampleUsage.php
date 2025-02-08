<?php

namespace Esalud\EnhancedLogging\Examples;

use Esalud\EnhancedLogging\Traits\ContextualLogging;

class PatientService
{
    use ContextualLogging;

    /**
     * Registrar un nuevo paciente en el sistema.
     *
     * @param array $patientData Datos del paciente
     * @return bool Resultado del registro
     */
    public function registerPatient(array $patientData)
    {
        try {
            // Log de inicio de registro
            $this->debugLog('Iniciando registro de paciente', [
                'email' => $patientData['email']
            ]);

            // Validación de datos (ejemplo simplificado)
            $this->validatePatientData($patientData);

            // Crear paciente
            $patient = $this->createPatient($patientData);

            // Log de registro exitoso
            $this->debugLog('Paciente registrado exitosamente', [
                'patient_id' => $patient->id,
                'email' => $patient->email
            ]);

            return true;
        } catch (\Exception $e) {
            // Log de error con información detallada
            $this->errorLog('Error en registro de paciente', [
                'error' => $e->getMessage(),
                'email' => $patientData['email'] ?? 'N/A',
                'trace' => $e->getTraceAsString()
            ]);

            return false;
        }
    }

    /**
     * Validar datos del paciente.
     *
     * @param array $data Datos a validar
     * @throws \InvalidArgumentException Si los datos no son válidos
     */
    private function validatePatientData(array $data)
    {
        // Validaciones de ejemplo
        if (empty($data['email'])) {
            throw new \InvalidArgumentException('Email es requerido');
        }

        if (empty($data['password'])) {
            throw new \InvalidArgumentException('Contraseña es requerida');
        }
    }

    /**
     * Crear registro de paciente.
     *
     * @param array $data Datos del paciente
     * @return Patient Instancia de paciente creada
     */
    private function createPatient(array $data)
    {
        // Lógica de creación de paciente (simulada)
        $patient = new Patient();
        $patient->email = $data['email'];
        $patient->save();

        return $patient;
    }
}

// Ejemplo de uso
$service = new PatientService();
$result = $service->registerPatient([
    'email' => 'ejemplo@esalud.com',
    'password' => 'contraseña_segura'
]);
