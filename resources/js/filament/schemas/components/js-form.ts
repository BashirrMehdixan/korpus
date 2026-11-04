import { createApp, h, shallowRef } from 'vue'
import type { JsComponentProps, JsComponentRenderer } from '@filament/schemas/js-component'
import { ensureFilamentStyles } from '../../forms/components/styles'
import JsForm from './JsForm.vue'

const mountJsForm: JsComponentRenderer = ({ host, props: initialProps, utilities }) => {
    ensureFilamentStyles()

    const props = shallowRef(initialProps)
    const application = createApp({
        setup: () => () => h(JsForm, {
            ...props.value,
            utilities,
        }),
    })

    application.mount(host)

    return {
        update(nextProps) {
            props.value = nextProps
        },
        destroy: () => application.unmount(),
    }
}

export default mountJsForm
