<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'

defineOptions({ inheritAttrs: false })

const props = defineProps<{
    configuration?: {
        roles?: Array<{ value: number | string; label: string }>
        defaultRole?: string
        [key: string]: any
    }
    utilities?: {
        $get: (path: string, isAbsolute?: boolean) => any
        $set: (path: string, value: any, isAbsolute?: boolean, isLive?: boolean) => Promise<any>
        $wire: any
        $state: any
        $statePath: string | null
    }
    id?: string | null
}>()

// Local reactive state mirroring Livewire form data
const form = ref<Record<string, any>>({
    name: '',
    surname: '',
    patronymic: '',
    username: '',
    phone: '',
    email: '',
    password: '',
    roles: [],
    registration_date: new Date().toISOString().substring(0, 16),
    status: true,
})

const isPasswordRevealed = ref(false)
const isRolesOpen = ref(false)
const roleSearch = ref('')

// Initialize from Livewire if state already exists
onMounted(() => {
    if (!props.utilities) return

    const fields = ['name', 'surname', 'patronymic', 'username', 'phone', 'email', 'password', 'roles', 'registration_date', 'status']
    for (const f of fields) {
        const val = props.utilities.$get(f)
        if (val !== undefined && val !== null) {
            form.value[f] = val
        }
    }

    // Default roles if specified
    if ((!form.value.roles || form.value.roles.length === 0) && props.configuration?.defaultRole && props.configuration?.roles) {
        const matched = props.configuration.roles.find(r => r.label.toLowerCase() === props.configuration?.defaultRole?.toLowerCase())
        if (matched) {
            form.value.roles = [matched.value]
            updateField('roles', form.value.roles)
        }
    }

    // Default status
    if (form.value.status === undefined || form.value.status === null) {
        form.value.status = true
        updateField('status', true)
    }

    // Default registration_date
    if (!form.value.registration_date) {
        const now = new Date()
        const localIso = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().substring(0, 16)
        form.value.registration_date = localIso
        updateField('registration_date', localIso.replace('T', ' ') + ':00')
    }
})

function updateField(path: string, val: any): void {
    form.value[path] = val
    if (props.utilities?.$set) {
        props.utilities.$set(path, val)
    }
}

function toggleRole(roleId: number | string): void {
    const current = Array.isArray(form.value.roles) ? [...form.value.roles] : []
    const idx = current.findIndex(v => String(v) === String(roleId))
    if (idx >= 0) {
        current.splice(idx, 1)
    } else {
        current.push(roleId)
    }
    updateField('roles', current)
}

function removeRole(roleId: number | string, event: Event): void {
    event.stopPropagation()
    const current = (form.value.roles || []).filter((v: any) => String(v) !== String(roleId))
    updateField('roles', current)
}

function getRoleLabel(roleId: number | string): string {
    const r = props.configuration?.roles?.find(item => String(item.value) === String(roleId))
    return r ? r.label : String(roleId)
}

const filteredRoles = computed(() => {
    const list = props.configuration?.roles || []
    if (!roleSearch.value) return list
    return list.filter(r => r.label.toLowerCase().includes(roleSearch.value.toLowerCase()))
})
</script>

<template>
    <div class="fi-js-form-container">
        <!-- Section: Şəxsi məlumatlar -->
        <div class="fi-js-section">
            <div class="fi-js-section-header">
                <h3 class="fi-js-section-title">Şəxsi məlumatlar</h3>
            </div>

            <div class="fi-js-grid">
                <!-- Ad -->
                <div class="fi-js-field">
                    <label class="fi-js-label">Ad <span class="fi-js-required">*</span></label>
                    <div class="fi-js-input-wrp">
                        <input v-model="form.name" type="text" required maxlength="255" class="fi-js-input"
                            placeholder="Adınızı daxil edin" @input="updateField('name', form.name)" />
                    </div>
                </div>

                <!-- Soyad -->
                <div class="fi-js-field">
                    <label class="fi-js-label">Soyad <span class="fi-js-required">*</span></label>
                    <div class="fi-js-input-wrp">
                        <input v-model="form.surname" type="text" required maxlength="255" class="fi-js-input"
                            placeholder="Soyadınızı daxil edin" @input="updateField('surname', form.surname)" />
                    </div>
                </div>

                <!-- Ata adı -->
                <div class="fi-js-field">
                    <label class="fi-js-label">Ata adı</label>
                    <div class="fi-js-input-wrp">
                        <input v-model="form.patronymic" type="text" maxlength="255" class="fi-js-input"
                            placeholder="Ata adını daxil edin" @input="updateField('patronymic', form.patronymic)" />
                    </div>
                </div>

                <!-- İstifadəçi adı -->
                <div class="fi-js-field">
                    <label class="fi-js-label">İstifadəçi adı</label>
                    <div class="fi-js-input-wrp">
                        <input v-model="form.username" type="text" maxlength="255" class="fi-js-input"
                            placeholder="İstifadəçi adı" @input="updateField('username', form.username)" />
                    </div>
                </div>

                <!-- Telefon nömrəsi -->
                <div class="fi-js-field">
                    <label class="fi-js-label">Telefon nömrəsi <span class="fi-js-required">*</span></label>
                    <div class="fi-js-input-wrp">
                        <input v-model="form.phone" type="tel" required maxlength="50" class="fi-js-input"
                            placeholder="+994" @input="updateField('phone', form.phone)" />
                    </div>
                </div>

                <!-- E-poçt -->
                <div class="fi-js-field">
                    <label class="fi-js-label">E-poçt <span class="fi-js-required">*</span></label>
                    <div class="fi-js-input-wrp">
                        <input v-model="form.email" type="email" required maxlength="255" class="fi-js-input"
                            placeholder="example@mail.com" @input="updateField('email', form.email)" />
                    </div>
                </div>

                <!-- Şifrə -->
                <div class="fi-js-field">
                    <label class="fi-js-label">Şifrə <span class="fi-js-required">*</span></label>
                    <div class="fi-js-input-wrp">
                        <input v-model="form.password" :type="isPasswordRevealed ? 'text' : 'password'" required
                            maxlength="255" class="fi-js-input" placeholder="••••••••"
                            @input="updateField('password', form.password)" />
                        <button type="button" class="fi-js-icon-btn" @click="isPasswordRevealed = !isPasswordRevealed"
                            :title="isPasswordRevealed ? 'Gizlət' : 'Göstər'">
                            <svg v-if="isPasswordRevealed" style="width: 1.125rem; height: 1.125rem;" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                            <svg v-else style="width: 1.125rem; height: 1.125rem;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Rollar (Multi-Select) -->
                <div class="fi-js-field" style="position: relative;">
                    <label class="fi-js-label">Rollar <span class="fi-js-required">*</span></label>
                    <div class="fi-js-input-wrp" style="cursor: pointer; min-height: 2.375rem; padding: 0.25rem 0.5rem;"
                        @click="isRolesOpen = !isRolesOpen">
                        <div style="display: flex; flex-wrap: wrap; gap: 0.25rem; flex: 1;">
                            <span v-for="roleId in form.roles" :key="String(roleId)" class="fi-js-badge">
                                {{ getRoleLabel(roleId) }}
                                <span class="fi-js-badge-remove" @click="removeRole(roleId, $event)">&times;</span>
                            </span>
                            <span v-if="!form.roles || form.roles.length === 0"
                                style="color: #9ca3af; font-size: 0.875rem; padding: 0.25rem 0.5rem;">
                                Rol seçin...
                            </span>
                        </div>
                        <svg style="width: 1rem; height: 1rem; color: #9ca3af; transition: transform 0.2s;"
                            :style="isRolesOpen ? 'transform: rotate(180deg);' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <!-- Dropdown -->
                    <div v-if="isRolesOpen" class="fi-js-dropdown">
                        <div style="padding: 0.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                            <input v-model="roleSearch" type="text" placeholder="Rolu axtarın..."
                                class="fi-js-search-input" @click.stop />
                        </div>
                        <ul
                            style="list-style: none; margin: 0; padding: 0.25rem 0; max-height: 12rem; overflow-y: auto;">
                            <li v-for="r in filteredRoles" :key="String(r.value)" class="fi-js-dropdown-item"
                                :class="{ 'is-selected': (form.roles || []).some((v: any) => String(v) === String(r.value)) }"
                                @click.stop="toggleRole(r.value)">
                                <span class="fi-js-checkbox"
                                    :class="{ 'checked': (form.roles || []).some((v: any) => String(v) === String(r.value)) }">
                                    <svg v-if="(form.roles || []).some((v: any) => String(v) === String(r.value))"
                                        style="width: 0.75rem; height: 0.75rem; color: #fff;" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span>{{ r.label }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Qeydiyyat tarixi -->
                <div class="fi-js-field">
                    <label class="fi-js-label">Qeydiyyat tarixi <span class="fi-js-required">*</span></label>
                    <div class="fi-js-input-wrp">
                        <input v-model="form.registration_date" type="datetime-local" required class="fi-js-input"
                            style="color-scheme: dark;"
                            @input="updateField('registration_date', form.registration_date ? form.registration_date.replace('T', ' ') + ':00' : null)" />
                    </div>
                </div>

                <!-- Aktivlik (ToggleButtons) -->
                <div class="fi-js-field" style="grid-column: 1 / -1;">
                    <label class="fi-js-label">Aktivlik <span class="fi-js-required">*</span></label>
                    <div class="fi-js-toggle-group">
                        <button type="button" class="fi-js-toggle-btn"
                            :class="{ 'is-active-success': form.status === true || form.status === 1 || form.status === '1' }"
                            @click="updateField('status', true)">
                            Aktiv
                        </button>
                        <button type="button" class="fi-js-toggle-btn"
                            :class="{ 'is-active-danger': form.status === false || form.status === 0 || form.status === '0' }"
                            @click="updateField('status', false)">
                            Deaktiv
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.fi-js-form-container {
    width: 100%;
}

.fi-js-section {
    border-radius: 0.75rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
    background-color: rgba(255, 255, 255, 0.03);
    padding: 1.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2);
}

:root:not(.dark) .fi-js-section {
    border: 1px solid #e5e7eb;
    background-color: #ffffff;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
}

.fi-js-section-header {
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

:root:not(.dark) .fi-js-section-header {
    border-bottom: 1px solid #f3f4f6;
}

.fi-js-section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0;
}

:root:not(.dark) .fi-js-section-title {
    color: #111827;
}

.fi-js-grid {
    display: grid;
    grid-template-columns: repeat(1, minmax(0, 1fr));
    gap: 1.25rem;
}

@media (min-width: 768px) {
    .fi-js-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

.fi-js-field {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}

.fi-js-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #e5e7eb;
}

:root:not(.dark) .fi-js-label {
    color: #374151;
}

.fi-js-required {
    color: #ef4444;
}

.fi-js-input-wrp {
    display: flex;
    align-items: center;
    width: 100%;
    min-height: 2.375rem;
    border-radius: 0.5rem;
    border: 1px solid rgba(255, 255, 255, 0.15);
    background-color: rgba(255, 255, 255, 0.05);
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    transition: all 0.15s;
    overflow: hidden;
}

:root:not(.dark) .fi-js-input-wrp {
    border: 1px solid #d1d5db;
    background-color: #ffffff;
}

.fi-js-input-wrp:focus-within {
    border-color: #f59e0b;
    box-shadow: 0 0 0 1px #f59e0b, 0 0 0 3px rgba(245, 158, 11, 0.2);
}

.fi-js-input {
    flex: 1;
    width: 100%;
    height: 100%;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    color: #ffffff;
    background: transparent;
    border: none;
    outline: none;
}

:root:not(.dark) .fi-js-input {
    color: #111827;
}

.fi-js-input::placeholder {
    color: #9ca3af;
}

.fi-js-icon-btn {
    padding: 0.25rem 0.625rem;
    background: transparent;
    border: none;
    color: #9ca3af;
    cursor: pointer;
}

.fi-js-icon-btn:hover {
    color: #ffffff;
}

:root:not(.dark) .fi-js-icon-btn:hover {
    color: #111827;
}

.fi-js-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.125rem 0.5rem;
    background-color: rgba(245, 158, 11, 0.15);
    color: #fbbf24;
    border: 1px solid rgba(245, 158, 11, 0.3);
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.fi-js-badge-remove {
    cursor: pointer;
    font-size: 0.875rem;
    line-height: 1;
    color: #f59e0b;
}

.fi-js-badge-remove:hover {
    color: #ffffff;
}

.fi-js-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 50;
    margin-top: 0.25rem;
    background-color: #18181b;
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 0.5rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
}

:root:not(.dark) .fi-js-dropdown {
    background-color: #ffffff;
    border: 1px solid #d1d5db;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.fi-js-search-input {
    width: 100%;
    padding: 0.375rem 0.5rem;
    border-radius: 0.375rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    background-color: rgba(255, 255, 255, 0.05);
    color: #ffffff;
    font-size: 0.8125rem;
    outline: none;
}

:root:not(.dark) .fi-js-search-input {
    border: 1px solid #d1d5db;
    background-color: #f9fafb;
    color: #111827;
}

.fi-js-dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    color: #e5e7eb;
    cursor: pointer;
}

:root:not(.dark) .fi-js-dropdown-item {
    color: #374151;
}

.fi-js-dropdown-item:hover {
    background-color: rgba(245, 158, 11, 0.15);
    color: #ffffff;
}

:root:not(.dark) .fi-js-dropdown-item:hover {
    background-color: #fef3c7;
    color: #92400e;
}

.fi-js-dropdown-item.is-selected {
    background-color: rgba(245, 158, 11, 0.25);
    color: #f59e0b;
    font-weight: 500;
}

.fi-js-checkbox {
    width: 1rem;
    height: 1rem;
    border-radius: 0.25rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
}

.fi-js-checkbox.checked {
    background-color: #f59e0b;
    border-color: #f59e0b;
}

.fi-js-toggle-group {
    display: inline-flex;
    border-radius: 0.5rem;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.fi-js-toggle-btn {
    padding: 0.4375rem 1.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    line-height: 1.25rem;
    border: 1px solid rgba(255, 255, 255, 0.15);
    background-color: rgba(255, 255, 255, 0.05);
    color: #9ca3af;
    cursor: pointer;
    transition: all 0.15s;
}

:root:not(.dark) .fi-js-toggle-btn {
    border: 1px solid #d1d5db;
    background-color: #ffffff;
    color: #4b5563;
}

.fi-js-toggle-btn:not(:first-child) {
    margin-left: -1px;
}

.fi-js-toggle-btn.is-active-success {
    background-color: #10b981;
    border-color: #10b981;
    color: #ffffff;
}

.fi-js-toggle-btn.is-active-danger {
    background-color: #ef4444;
    border-color: #ef4444;
    color: #ffffff;
}
</style>
