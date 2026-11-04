// Injects Filament Vue components styles directly into document head
export function ensureFilamentStyles(): void {
    if (typeof document === 'undefined') return

    const id = 'filament-custom-field-styles'
    let style = document.getElementById(id) as HTMLStyleElement | null
    if (!style) {
        style = document.createElement('style')
        style.id = id
        document.head.appendChild(style)
    }

    style.textContent = `
/* =========================================================================
   1. FILAMENT STANDALONE CUSTOM FIELDS (TextInput, Select, etc.)
   ========================================================================= */

.fi-custom-field-wrp {
    display: flex;
    align-items: center;
    position: relative;
    width: 100%;
    min-height: 2.625rem;
    border-radius: 0.75rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
    background-color: rgba(24, 24, 27, 0.65);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15), inset 0 1px 1px rgba(255, 255, 255, 0.05);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    overflow: hidden;
}

:root:not(.dark) .fi-custom-field-wrp {
    border: 1px solid #d4d4d8;
    background-color: #ffffff;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.fi-custom-field-wrp:focus-within {
    border-color: #f59e0b;
    background-color: rgba(24, 24, 27, 0.95);
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.22), 0 4px 16px rgba(245, 158, 11, 0.1);
    transform: translateY(-0.5px);
}

:root:not(.dark) .fi-custom-field-wrp:focus-within {
    border-color: #f59e0b;
    background-color: #ffffff;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
}

.fi-custom-field-wrp.is-invalid {
    border-color: #f43f5e;
    box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.2);
}

.fi-custom-field-wrp.is-disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

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

.fi-custom-textarea {
    display: block;
    width: 100%;
    min-height: 5rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.5;
    color: #ffffff;
    background-color: transparent;
    border: none;
    outline: none;
    resize: vertical;
}

:root:not(.dark) .fi-custom-textarea {
    color: #111827;
}

.fi-custom-textarea::placeholder {
    color: #9ca3af;
}

/* Standalone Select Styles */
.fi-select-trigger {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    min-height: 2.625rem;
    padding: 0.375rem 0.75rem;
    border-radius: 0.75rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
    background-color: rgba(24, 24, 27, 0.65);
    color: #ffffff;
    font-size: 0.875rem;
    cursor: pointer;
    text-align: left;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

:root:not(.dark) .fi-select-trigger {
    border: 1px solid #d4d4d8;
    background-color: #ffffff;
    color: #111827;
}

.fi-select-trigger:focus,
.fi-select-trigger.is-open {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.22);
}

.fi-select-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.2rem 0.625rem;
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(245, 158, 11, 0.08) 100%);
    color: #fbbf24;
    border: 1px solid rgba(245, 158, 11, 0.35);
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.fi-select-badge-remove {
    cursor: pointer;
    font-size: 0.95rem;
    line-height: 1;
    color: #f59e0b;
}

.fi-select-badge-remove:hover {
    color: #ffffff;
}

.fi-select-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 50;
    margin-top: 0.35rem;
    background: rgba(24, 24, 27, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 0.875rem;
    backdrop-filter: blur(20px);
    box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.6);
    overflow: hidden;
}

:root:not(.dark) .fi-select-dropdown {
    background: #ffffff;
    border: 1px solid #e4e4e7;
    box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.1);
}

.fi-select-dropdown-search {
    padding: 0.625rem 0.875rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

:root:not(.dark) .fi-select-dropdown-search {
    border-bottom: 1px solid #f4f4f5;
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

.fi-select-item {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.84rem;
    color: #e4e4e7;
    cursor: pointer;
    transition: all 0.15s;
}

:root:not(.dark) .fi-select-item {
    color: #3f3f46;
}

.fi-select-item:hover {
    background-color: rgba(245, 158, 11, 0.12);
    color: #fbbf24;
}

.fi-select-item.is-selected {
    background: rgba(245, 158, 11, 0.18);
    color: #f59e0b;
    font-weight: 600;
}

/* =========================================================================
   2. MODERN JS FORM STYLES (JsForm.vue)
   ========================================================================= */

.fi-js-dynamic-form {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 1.75rem;
    position: relative;
    font-family: inherit;
}

.fi-js-dynamic-form.is-fullscreen {
    position: fixed;
    inset: 0;
    z-index: 99999;
    background: radial-gradient(circle at 50% 10%, #18181b 0%, #09090b 100%);
    padding: 3rem 4rem;
    overflow-y: auto;
    backdrop-filter: blur(24px);
    box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.9);
}

:root:not(.dark) .fi-js-dynamic-form.is-fullscreen {
    background: radial-gradient(circle at 50% 10%, #f9fafb 0%, #f3f4f6 100%);
}

.fi-modern-card {
    border-radius: 1.25rem;
    border: 1px solid rgba(255, 255, 255, 0.08);
    background: linear-gradient(180deg, rgba(255, 255, 255, 0.035) 0%, rgba(255, 255, 255, 0.015) 100%);
    backdrop-filter: blur(20px);
    padding: 2rem 2.25rem;
    box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.08);
    transition: border-color 0.2s, box-shadow 0.2s;
}

:root:not(.dark) .fi-modern-card {
    border: 1px solid #e4e4e7;
    background: linear-gradient(180deg, #ffffff 0%, #fafafa 100%);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), inset 0 1px 0 #ffffff;
}

.fi-modern-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

:root:not(.dark) .fi-modern-header {
    border-bottom: 1px solid #f4f4f5;
}

.fi-header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.fi-header-badge-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.75rem;
    height: 2.75rem;
    border-radius: 0.75rem;
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(245, 158, 11, 0.05) 100%);
    border: 1px solid rgba(245, 158, 11, 0.35);
    color: #f59e0b;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.15);
}

:root:not(.dark) .fi-header-badge-icon {
    background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 100%);
    border: 1px solid #fde68a;
    color: #d97706;
}

.fi-modern-title {
    font-size: 1.25rem;
    font-weight: 700;
    letter-spacing: -0.02em;
    color: #fafafa;
    margin: 0;
}

:root:not(.dark) .fi-modern-title {
    color: #09090b;
}

.fi-modern-desc {
    font-size: 0.8125rem;
    color: #a1a1aa;
    margin: 0.25rem 0 0 0;
}

:root:not(.dark) .fi-modern-desc {
    color: #71717a;
}

.fi-modern-pill-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4375rem 0.875rem;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #f59e0b;
    background: rgba(245, 158, 11, 0.1);
    border: 1px solid rgba(245, 158, 11, 0.25);
    border-radius: 9999px;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    backdrop-filter: blur(8px);
}

.fi-modern-pill-btn:hover {
    background: rgba(245, 158, 11, 0.2);
    color: #fbbf24;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
}

.fi-modern-field {
    display: flex;
    flex-direction: column;
    gap: 0.45rem;
    min-width: 0;
}

.fi-modern-label-row {
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.fi-modern-label {
    font-size: 0.8125rem;
    font-weight: 600;
    letter-spacing: 0.015em;
    color: #e4e4e7;
    text-transform: capitalize;
}

:root:not(.dark) .fi-modern-label {
    color: #27272a;
}

.fi-modern-required-dot {
    color: #f43f5e;
    font-size: 1.125rem;
    line-height: 1;
    font-weight: 700;
}

.fi-modern-helper-text {
    font-size: 0.75rem;
    color: #71717a;
    margin: 0.2rem 0 0 0;
}

.fi-modern-input-wrp {
    display: flex;
    align-items: center;
    position: relative;
    width: 100%;
    min-height: 2.625rem;
    border-radius: 0.75rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
    background-color: rgba(24, 24, 27, 0.65);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15), inset 0 1px 1px rgba(255, 255, 255, 0.05);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    overflow: hidden;
}

:root:not(.dark) .fi-modern-input-wrp {
    border: 1px solid #d4d4d8;
    background-color: #ffffff;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.fi-modern-input-wrp:focus-within {
    border-color: #f59e0b;
    background-color: rgba(24, 24, 27, 0.95);
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.22), 0 4px 16px rgba(245, 158, 11, 0.1);
    transform: translateY(-0.5px);
}

:root:not(.dark) .fi-modern-input-wrp:focus-within {
    border-color: #f59e0b;
    background-color: #ffffff;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
}

.fi-modern-input {
    flex: 1;
    width: 100%;
    height: 100%;
    padding: 0.625rem 0.875rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    color: #fafafa;
    background: transparent;
    border: none;
    outline: none;
}

:root:not(.dark) .fi-modern-input {
    color: #18181b;
}

.fi-modern-input::placeholder {
    color: #71717a;
    font-size: 0.84rem;
}

.fi-modern-affix {
    padding: 0 0.875rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #a1a1aa;
    background: rgba(255, 255, 255, 0.03);
    border-right: 1px solid rgba(255, 255, 255, 0.08);
}

:root:not(.dark) .fi-modern-affix {
    background: #f4f4f5;
    border-right: 1px solid #e4e4e7;
    color: #71717a;
}

.fi-modern-eye-btn {
    padding: 0.35rem 0.75rem;
    background: transparent;
    border: none;
    color: #71717a;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: color 0.15s;
}

.fi-modern-eye-btn:hover {
    color: #fbbf24;
}

/* Select Box & Chips */
.fi-modern-select-box {
    position: relative;
    width: 100%;
}

.fi-modern-select-trigger {
    cursor: pointer;
    justify-content: space-between;
    padding: 0.3rem 0.65rem;
}

.fi-modern-select-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 0.35rem;
    align-items: center;
    flex: 1;
    min-height: 2rem;
}

.fi-modern-placeholder {
    color: #71717a;
    font-size: 0.875rem;
    padding-left: 0.25rem;
}

.fi-modern-selected-text {
    color: #fafafa;
    font-size: 0.875rem;
    padding-left: 0.25rem;
}

:root:not(.dark) .fi-modern-selected-text {
    color: #18181b;
}

.fi-modern-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.2rem 0.625rem;
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(245, 158, 11, 0.08) 100%);
    color: #fbbf24;
    border: 1px solid rgba(245, 158, 11, 0.35);
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
}

.fi-modern-chip-remove {
    background: transparent;
    border: none;
    cursor: pointer;
    font-size: 0.95rem;
    line-height: 1;
    color: #f59e0b;
    padding: 0;
    margin: 0;
    display: flex;
    align-items: center;
    transition: transform 0.1s, color 0.1s;
}

.fi-modern-chip-remove:hover {
    color: #ffffff;
    transform: scale(1.15);
}

.fi-modern-arrow-icon {
    display: flex;
    align-items: center;
    padding-right: 0.35rem;
    color: #71717a;
    transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.fi-modern-arrow-icon.is-flipped {
    transform: rotate(180deg);
    color: #f59e0b;
}

.fi-modern-dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 50;
    margin-top: 0.35rem;
    background: rgba(24, 24, 27, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 0.875rem;
    backdrop-filter: blur(20px);
    box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.6);
    overflow: hidden;
}

:root:not(.dark) .fi-modern-dropdown-menu {
    background: #ffffff;
    border: 1px solid #e4e4e7;
    box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.1);
}

.fi-modern-search-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 0.875rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

:root:not(.dark) .fi-modern-search-header {
    border-bottom: 1px solid #f4f4f5;
}

.fi-modern-search-input {
    width: 100%;
    background: transparent;
    border: none;
    outline: none;
    color: #fafafa;
    font-size: 0.8125rem;
}

:root:not(.dark) .fi-modern-search-input {
    color: #18181b;
}

.fi-modern-options-scroll {
    max-height: 14rem;
    overflow-y: auto;
    padding: 0.35rem;
}

.fi-modern-option-row {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.84rem;
    color: #e4e4e7;
    cursor: pointer;
    transition: all 0.15s;
}

:root:not(.dark) .fi-modern-option-row {
    color: #3f3f46;
}

.fi-modern-option-row:hover {
    background-color: rgba(245, 158, 11, 0.12);
    color: #fbbf24;
}

.fi-modern-option-row.is-active {
    background: rgba(245, 158, 11, 0.18);
    color: #f59e0b;
    font-weight: 600;
}

.fi-modern-check-box {
    width: 1.1rem;
    height: 1.1rem;
    border-radius: 0.3rem;
    border: 1.5px solid rgba(255, 255, 255, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
}

.fi-modern-check-box.checked {
    background: #f59e0b;
    border-color: #f59e0b;
    color: #ffffff;
}

.fi-modern-segmented-switch {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 9999px;
    gap: 0.25rem;
}

:root:not(.dark) .fi-modern-segmented-switch {
    background: #f4f4f5;
    border: 1px solid #e4e4e7;
}

.fi-modern-switch-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.375rem 1.125rem;
    font-size: 0.8125rem;
    font-weight: 500;
    color: #71717a;
    background: transparent;
    border: none;
    border-radius: 9999px;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.fi-modern-switch-btn:hover {
    color: #e4e4e7;
}

:root:not(.dark) .fi-modern-switch-btn:hover {
    color: #18181b;
}

.fi-switch-dot {
    width: 0.45rem;
    height: 0.45rem;
    border-radius: 9999px;
    background-color: currentColor;
    opacity: 0.5;
}

.fi-modern-switch-btn.is-active-success {
    background: #10b981;
    color: #ffffff;
    font-weight: 600;
    box-shadow: 0 2px 10px rgba(16, 185, 129, 0.35);
}

.fi-modern-switch-btn.is-active-success .fi-switch-dot {
    background: #ffffff;
    opacity: 1;
}

.fi-modern-switch-btn.is-active-danger {
    background: #f43f5e;
    color: #ffffff;
    font-weight: 600;
    box-shadow: 0 2px 10px rgba(244, 63, 94, 0.35);
}

.fi-modern-switch-btn.is-active-danger .fi-switch-dot {
    background: #ffffff;
    opacity: 1;
}

.fi-modern-switch-btn.is-active-primary {
    background: #f59e0b;
    color: #ffffff;
    font-weight: 600;
    box-shadow: 0 2px 10px rgba(245, 158, 11, 0.35);
}

.fi-modern-switch-btn.is-active-primary .fi-switch-dot {
    background: #ffffff;
    opacity: 1;
}

.fi-modern-textarea-wrp {
    height: auto;
    min-height: 6rem;
}

.fi-modern-textarea {
    width: 100%;
    height: 100%;
    padding: 0.625rem 0.875rem;
    font-size: 0.875rem;
    color: #fafafa;
    background: transparent;
    border: none;
    outline: none;
    resize: vertical;
}

:root:not(.dark) .fi-modern-textarea {
    color: #18181b;
}

/* =========================================================================
   3. MODERN INFOLIST STYLES (JsInfolist.vue)
   ========================================================================= */

.fi-js-dynamic-infolist {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 1.75rem;
    position: relative;
    font-family: inherit;
}

.fi-js-dynamic-infolist.is-fullscreen {
    position: fixed;
    inset: 0;
    z-index: 99999;
    background: radial-gradient(circle at 50% 10%, #18181b 0%, #09090b 100%);
    padding: 3rem 4rem;
    overflow-y: auto;
    backdrop-filter: blur(24px);
    box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.9);
}

:root:not(.dark) .fi-js-dynamic-infolist.is-fullscreen {
    background: radial-gradient(circle at 50% 10%, #f9fafb 0%, #f3f4f6 100%);
}

.fi-infolist-card {
    border-radius: 1.25rem;
    border: 1px solid rgba(255, 255, 255, 0.08);
    background: linear-gradient(180deg, rgba(255, 255, 255, 0.035) 0%, rgba(255, 255, 255, 0.015) 100%);
    backdrop-filter: blur(20px);
    padding: 2rem 2.25rem;
    box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.08);
}

:root:not(.dark) .fi-infolist-card {
    border: 1px solid #e4e4e7;
    background: linear-gradient(180deg, #ffffff 0%, #fafafa 100%);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), inset 0 1px 0 #ffffff;
}

.fi-infolist-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

:root:not(.dark) .fi-infolist-header {
    border-bottom: 1px solid #f4f4f5;
}

.fi-infolist-title {
    font-size: 1.25rem;
    font-weight: 700;
    letter-spacing: -0.02em;
    color: #fafafa;
    margin: 0;
}

:root:not(.dark) .fi-infolist-title {
    color: #09090b;
}

.fi-infolist-desc {
    font-size: 0.8125rem;
    color: #a1a1aa;
    margin: 0.25rem 0 0 0;
}

.fi-infolist-pill-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4375rem 0.875rem;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #818cf8;
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(99, 102, 241, 0.25);
    border-radius: 9999px;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.fi-infolist-pill-btn:hover {
    background: rgba(99, 102, 241, 0.2);
    color: #a5b4fc;
    transform: translateY(-1px);
}

.fi-infolist-entry {
    display: flex;
    flex-direction: column;
    gap: 0.45rem;
    padding: 0.875rem 1.125rem;
    border-radius: 0.875rem;
    background: rgba(255, 255, 255, 0.025);
    border: 1px solid rgba(255, 255, 255, 0.05);
    transition: all 0.15s;
}

:root:not(.dark) .fi-infolist-entry {
    background: #f9fafb;
    border: 1px solid #f3f4f6;
}

.fi-infolist-entry:hover {
    border-color: rgba(255, 255, 255, 0.12);
    background: rgba(255, 255, 255, 0.04);
}

:root:not(.dark) .fi-infolist-entry:hover {
    background: #f4f4f5;
    border-color: #e4e4e7;
}

.fi-entry-label-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.fi-entry-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #71717a;
}

:root:not(.dark) .fi-entry-label {
    color: #a1a1aa;
}

.fi-copy-btn {
    background: transparent;
    border: none;
    color: #71717a;
    cursor: pointer;
    padding: 0.125rem;
    display: flex;
    align-items: center;
    transition: color 0.15s;
}

.fi-copy-btn:hover {
    color: #fafafa;
}

:root:not(.dark) .fi-copy-btn:hover {
    color: #18181b;
}

.fi-entry-value-box {
    min-height: 1.5rem;
    display: flex;
    align-items: center;
}

.fi-entry-text {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #fafafa;
    word-break: break-word;
}

:root:not(.dark) .fi-entry-text {
    color: #09090b;
}

.fi-entry-empty {
    font-size: 0.875rem;
    color: #52525b;
}

.fi-entry-chips-row {
    display: flex;
    flex-wrap: wrap;
    gap: 0.35rem;
}

.fi-entry-chip {
    padding: 0.2rem 0.625rem;
    font-size: 0.8125rem;
    font-weight: 500;
    color: #d4d4d8;
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 9999px;
}

:root:not(.dark) .fi-entry-chip {
    background: #e4e4e7;
    border-color: #d4d4d8;
    color: #27272a;
}

.fi-entry-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.fi-entry-badge.is-success {
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.35);
    color: #34d399;
}

.fi-entry-badge.is-danger {
    background: rgba(244, 63, 94, 0.15);
    border: 1px solid rgba(244, 63, 94, 0.35);
    color: #fb7185;
}

.fi-entry-badge.is-warning {
    background: rgba(245, 158, 11, 0.15);
    border: 1px solid rgba(245, 158, 11, 0.35);
    color: #fbbf24;
}

.fi-entry-badge.is-primary {
    background: rgba(99, 102, 241, 0.15);
    border: 1px solid rgba(99, 102, 241, 0.35);
    color: #a5b4fc;
}
`
}
