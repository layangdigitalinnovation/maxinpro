<?php

namespace App\Models\Concerns;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Attach to any model to automatically record created/updated/deleted events
 * into audit_logs. Add a `auditLabel()` method on the model to control what
 * shows up as the human-readable label (defaults to a `title`/`name` attribute
 * if present, else the primary key).
 */
trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            $model->writeAuditLog('created', []);
        });

        static::updated(function ($model) {
            $changes = [];
            foreach ($model->getChanges() as $field => $newValue) {
                if (in_array($field, ['updated_at'], true)) {
                    continue;
                }
                $changes[$field] = [
                    'old' => $model->getOriginal($field),
                    'new' => $newValue,
                ];
            }
            if (! empty($changes)) {
                $model->writeAuditLog('updated', $changes);
            }
        });

        static::deleted(function ($model) {
            $model->writeAuditLog('deleted', []);
        });
    }

    protected function writeAuditLog(string $action, array $changes): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'auditable_type' => static::class,
            'auditable_id' => $this->getKey(),
            'auditable_label' => method_exists($this, 'auditLabel')
                ? $this->auditLabel()
                : ($this->title ?? $this->name ?? (string) $this->getKey()),
            'changes' => $changes ?: null,
            'ip_address' => Request::ip(),
        ]);
    }
}
