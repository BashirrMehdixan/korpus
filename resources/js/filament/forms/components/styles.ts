// Injects standard Filament-matching styles directly into document head
export function ensureFilamentStyles(): void {
    if (typeof document === 'undefined') return
    if (document.getElementById('filament-custom-field-styles')) return

    const style = document.createElement('style')
    style.id = 'filament-custom-field-styles'
    style.textContent = `
/* --- Filament Form Custom Fields Base --- */
.fi-custom-field-wrp {
    display: flex;
    align-items: center;
    position: relative;
    width: 100%;
    min-height: 2.375rem;
    border-radius: 0.5rem;
    border: 1px solid rgba(255, 255, 255, 0.15);
    background-color: rgba(255, 255, 255, 0.05);
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    transition: all 0.15s ease-in-out;
    overflow: hidden;
}

:root:not(.dark) .fi-custom-field-wrp {
    border: 1px solid #d1d5db;
    background-color: #ffffff;
}

.fi-custom-field-wrp:focus-within {
    border-color: #f59e0b;
    box-shadow: 0 0 0 1px #f59e0b, 0 0 0 3px rgba(245, 158, 11, 0.2);
}

.fi-custom-field-wrp.is-invalid {
    border-color: #ef4444;
}

.fi-custom-field-wrp.is-disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* --- Input Elements --- */
.fi-custom-input {
    flex: 1;
    width: 100%;
    height: 100%;
    min-height: 2.25rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    color: #ffffff;
    background: transparent;
    border: none;
    outline: none;
    box-shadow: none;
}

:root:not(.dark) .fi-custom-input {
    color: #111827;
}

.fi-custom-input::placeholder {
    color: #9ca3af;
}

.fi-custom-input:disabled {
    cursor: not-allowed;
}

.fi-custom-input[type="date"],
.fi-custom-input[type="datetime-local"] {
    color-scheme: dark;
}

:root:not(.dark) .fi-custom-input[type="date"],
:root:not(.dark) .fi-custom-input[type="datetime-local"] {
    color-scheme: light;
}

/* --- Affixes (Prefix / Suffix) --- */
.fi-custom-affix {
    display: inline-flex;
    align-items: center;
    padding: 0 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #9ca3af;
    background-color: rgba(255, 255, 255, 0.05);
    user-select: none;
    height: 100%;
    white-space: nowrap;
}

:root:not(.dark) .fi-custom-affix {
    background-color: #f9fafb;
    color: #6b7280;
}

.fi-custom-prefix {
    border-right: 1px solid rgba(255, 255, 255, 0.1);
}

:root:not(.dark) .fi-custom-prefix {
    border-right: 1px solid #e5e7eb;
}

.fi-custom-suffix {
    border-left: 1px solid rgba(255, 255, 255, 0.1);
}

:root:not(.dark) .fi-custom-suffix {
    border-left: 1px solid #e5e7eb;
}

/* --- Action Buttons inside input (e.g. reveal password) --- */
.fi-custom-icon-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.25rem 0.625rem;
    color: #9ca3af;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: color 0.15s;
}

.fi-custom-icon-btn:hover {
    color: #ffffff;
}

:root:not(.dark) .fi-custom-icon-btn:hover {
    color: #111827;
}

/* --- Textarea --- */
.fi-custom-textarea {
    display: block;
    width: 100%;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    color: #ffffff;
    background: transparent;
    border: none;
    outline: none;
    resize: vertical;
}

:root:not(.dark) .fi-custom-textarea {
    color: #111827;
}

/* --- Toggle Buttons --- */
.fi-toggle-group {
    display: inline-flex;
    flex-wrap: wrap;
    border-radius: 0.5rem;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    background-color: rgba(255, 255, 255, 0.03);
}

.fi-toggle-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.4375rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    line-height: 1.25rem;
    border: 1px solid rgba(255, 255, 255, 0.15);
    background-color: rgba(255, 255, 255, 0.05);
    color: #9ca3af;
    cursor: pointer;
    transition: all 0.15s ease-in-out;
    user-select: none;
}

:root:not(.dark) .fi-toggle-btn {
    border: 1px solid #d1d5db;
    background-color: #ffffff;
    color: #4b5563;
}

.fi-toggle-btn:not(:first-child) {
    margin-left: -1px;
}

.fi-toggle-btn.is-first {
    border-top-left-radius: 0.5rem;
    border-bottom-left-radius: 0.5rem;
}

.fi-toggle-btn.is-last {
    border-top-right-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
}

.fi-toggle-btn:hover:not(:disabled) {
    background-color: rgba(255, 255, 255, 0.1);
    color: #ffffff;
}

:root:not(.dark) .fi-toggle-btn:hover:not(:disabled) {
    background-color: #f3f4f6;
    color: #111827;
}

.fi-toggle-btn.is-active {
    background-color: #f59e0b;
    border-color: #f59e0b;
    color: #ffffff;
    z-index: 10;
}

.fi-toggle-btn.is-active-success {
    background-color: #10b981;
    border-color: #10b981;
    color: #ffffff;
    z-index: 10;
}

.fi-toggle-btn.is-active-danger {
    background-color: #ef4444;
    border-color: #ef4444;
    color: #ffffff;
    z-index: 10;
}

/* --- Select Dropdown & Tags --- */
.fi-select-trigger {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    min-height: 2.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 0.5rem;
    border: 1px solid rgba(255, 255, 255, 0.15);
    background-color: rgba(255, 255, 255, 0.05);
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    cursor: pointer;
    text-align: left;
    transition: all 0.15s ease-in-out;
}

:root:not(.dark) .fi-select-trigger {
    border: 1px solid #d1d5db;
    background-color: #ffffff;
}

.fi-select-trigger:focus,
.fi-select-trigger.is-open {
    outline: none;
    border-color: #f59e0b;
    box-shadow: 0 0 0 1px #f59e0b, 0 0 0 3px rgba(245, 158, 11, 0.2);
}

.fi-select-badge {
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

.fi-select-badge-remove {
    cursor: pointer;
    font-size: 0.875rem;
    line-height: 1;
    color: #f59e0b;
    margin-left: 0.125rem;
}

.fi-select-badge-remove:hover {
    color: #ffffff;
}

.fi-select-dropdown {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    z-index: 50;
    background-color: #18181b;
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 0.5rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
    max-height: 15rem;
    overflow-y: auto;
}

:root:not(.dark) .fi-select-dropdown {
    background-color: #ffffff;
    border: 1px solid #d1d5db;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.fi-select-dropdown-search {
    padding: 0.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

:root:not(.dark) .fi-select-dropdown-search {
    border-bottom: 1px solid #e5e7eb;
}

.fi-select-search-input {
    width: 100%;
    padding: 0.375rem 0.5rem;
    border-radius: 0.375rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    background-color: rgba(255, 255, 255, 0.05);
    color: #ffffff;
    font-size: 0.8125rem;
    outline: none;
}

:root:not(.dark) .fi-select-search-input {
    border: 1px solid #d1d5db;
    background-color: #f9fafb;
    color: #111827;
}

.fi-select-search-input:focus {
    border-color: #f59e0b;
}

.fi-select-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    color: #e5e7eb;
    cursor: pointer;
    transition: background-color 0.1s;
}

:root:not(.dark) .fi-select-item {
    color: #374151;
}

.fi-select-item:hover {
    background-color: rgba(245, 158, 11, 0.15);
    color: #ffffff;
}

:root:not(.dark) .fi-select-item:hover {
    background-color: #fef3c7;
    color: #92400e;
}

.fi-select-item.is-selected {
    background-color: rgba(245, 158, 11, 0.25);
    color: #f59e0b;
    font-weight: 500;
}

/* --- Full JS Form Component Styles --- */
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
`
    document.head.appendChild(style)
}

