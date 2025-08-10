<?php

namespace App\Traits;

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Auth;

trait NotifiesUsers
{
    /**
     * Create notification for current user.
     */
    protected function notifyUser($title, $message, $type = 'info', $actionUrl = null)
    {
        NotificationController::create(
            Auth::id(),
            $title,
            $message,
            $type,
            null,
            $actionUrl
        );
    }

    /**
     * Create notification for specific user.
     */
    protected function notifySpecificUser($userId, $title, $message, $type = 'info', $actionUrl = null)
    {
        NotificationController::create(
            $userId,
            $title,
            $message,
            $type,
            null,
            $actionUrl
        );
    }

    /**
     * Notify all admins.
     */
    protected function notifyAdmins($title, $message, $type = 'info', $actionUrl = null)
    {
        NotificationController::notifyAdmins($title, $message, $type, null, $actionUrl);
    }

    /**
     * Notify all users.
     */
    protected function notifyAllUsers($title, $message, $type = 'info', $actionUrl = null)
    {
        NotificationController::notifyAllUsers($title, $message, $type, null, $actionUrl);
    }

    /**
     * Create success notification for CRUD operations.
     */
    protected function notifySuccess($operation, $entity, $entityName = null)
    {
        $entityName = $entityName ?: class_basename($entity);
        
        $messages = [
            'created' => "Data {$entityName} berhasil ditambahkan",
            'updated' => "Data {$entityName} berhasil diperbarui", 
            'deleted' => "Data {$entityName} berhasil dihapus"
        ];

        $types = [
            'created' => strtolower($entityName) . '_created',
            'updated' => strtolower($entityName) . '_updated',
            'deleted' => strtolower($entityName) . '_deleted'
        ];

        $this->notifyUser(
            ucfirst($operation) . ' ' . $entityName,
            $messages[$operation] ?? "Operasi {$operation} berhasil",
            $types[$operation] ?? 'success'
        );

        // Also notify admins for important operations
        if (Auth::user()->role !== 'admin') {
            $this->notifyAdmins(
                ucfirst($operation) . ' ' . $entityName,
                Auth::user()->name . ' ' . $messages[$operation] ?? "melakukan operasi {$operation}",
                $types[$operation] ?? 'info'
            );
        }
    }

    /**
     * Create error notification.
     */
    protected function notifyError($operation, $entity, $error = null)
    {
        $entityName = is_string($entity) ? $entity : class_basename($entity);
        
        $this->notifyUser(
            "Error {$operation} {$entityName}",
            $error ?: "Gagal melakukan operasi {$operation} pada {$entityName}",
            'error'
        );
    }

    /**
     * Create transfer notification.
     */
    protected function notifyTransfer($transfer, $operation)
    {
        $employee = $transfer->employee;
        $fromVillage = $transfer->fromVillage;
        $toVillage = $transfer->toVillage;

        $messages = [
            'created' => "Mutasi baru untuk {$employee->name} dari {$fromVillage->name} ke {$toVillage->name}",
            'updated' => "Data mutasi {$employee->name} telah diperbarui",
            'approved' => "Mutasi {$employee->name} telah disetujui",
            'rejected' => "Mutasi {$employee->name} ditolak",
            'completed' => "Mutasi {$employee->name} telah selesai"
        ];

        // Notify the employee
        $this->notifySpecificUser(
            $employee->id,
            "Mutasi " . ucfirst($operation),
            $messages[$operation] ?? "Status mutasi Anda telah berubah",
            'transfer_' . $operation,
            route('user.dashboard')
        );

        // Notify admins
        $this->notifyAdmins(
            "Mutasi " . ucfirst($operation),
            $messages[$operation] ?? "Status mutasi telah berubah",
            'transfer_' . $operation,
            route('admin.transfers.show', $transfer->id)
        );
    }

    /**
     * Create village notification.
     */
    protected function notifyVillage($village, $operation)
    {
        $messages = [
            'created' => "Desa baru '{$village->name}' telah ditambahkan",
            'updated' => "Data desa '{$village->name}' telah diperbarui",
            'deleted' => "Desa '{$village->name}' telah dihapus"
        ];

        $this->notifyAdmins(
            "Desa " . ucfirst($operation),
            $messages[$operation] ?? "Operasi pada desa telah dilakukan",
            'village_' . $operation,
            $operation !== 'deleted' ? route('admin.villages.edit', $village->id) : null
        );
    }

    /**
     * Create user management notification.
     */
    protected function notifyUserManagement($user, $operation)
    {
        $messages = [
            'created' => "Pengguna baru '{$user->name}' telah ditambahkan",
            'updated' => "Data pengguna '{$user->name}' telah diperbarui",
            'deleted' => "Pengguna '{$user->name}' telah dihapus",
            'activated' => "Pengguna '{$user->name}' telah diaktifkan",
            'deactivated' => "Pengguna '{$user->name}' telah dinonaktifkan"
        ];

        // Notify the user if not deleted
        if ($operation !== 'deleted') {
            $this->notifySpecificUser(
                $user->id,
                "Akun " . ucfirst($operation),
                $messages[$operation] ?? "Status akun Anda telah berubah",
                'user_' . $operation
            );
        }

        // Notify other admins
        $this->notifyAdmins(
            "Pengguna " . ucfirst($operation),
            Auth::user()->name . ' ' . strtolower($messages[$operation]),
            'user_' . $operation,
            $operation !== 'deleted' ? route('admin.users.edit', $user->id) : null
        );
    }
}
