import { t as useLocale } from "./useLocale-DzvATyP9.js";
import { createVNode, defineComponent, resolveDynamicComponent, shallowRef, unref, useSSRContext } from "vue";
import { ssrInterpolate, ssrRenderAttrs, ssrRenderList, ssrRenderVNode } from "vue/server-renderer";
import { RiBookOpenLine, RiCoinsLine, RiPresentationLine, RiTeamLine, RiUser3Line } from "@remixicon/vue";
//#region resources/js/pages/index.vue?vue&type=script&setup=true&lang.ts
var index_vue_vue_type_script_setup_true_lang_default = /*@__PURE__*/ defineComponent({
	__name: "index",
	__ssrInlineRender: true,
	setup(__props) {
		const { t } = useLocale();
		const dashboardCards = shallowRef([
			{
				title: "Tələbələr",
				description: "Tələbə qeydlərini görüntüləyin və idarə edin",
				icon: RiTeamLine
			},
			{
				title: "Müəllimlər",
				description: "Müəllim profillərini görüntüləyin və idarə edin",
				icon: RiUser3Line
			},
			{
				title: "Qruplar",
				description: "Sinf qruplarını və qeydiyyatları idarə edin",
				icon: RiPresentationLine
			},
			{
				title: "Kurslar",
				description: "Kurs kataloqunu görüntüləyin və redaktə edin",
				icon: RiBookOpenLine
			},
			{
				title: "Maliyyə",
				description: "Ödənişləri və fakturaları izləyin",
				icon: RiCoinsLine
			}
		]);
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(_attrs)}><div class="mb-8"><h1 class="mb-1 text-xl font-semibold text-gray-900 dark:text-white">${ssrInterpolate(unref(t)("Axşamınız xeyir, Jalə!"))}</h1><p class="text-sm text-gray-400 dark:text-gray-500">${ssrInterpolate(unref(t)("Bu gün nə etmək istərdiniz?"))}</p></div><div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3"><!--[-->`);
			ssrRenderList(dashboardCards.value, (card) => {
				_push(`<div class="group cursor-pointer rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-all hover:shadow-md dark:bg-gray-800 dark:ring-gray-700 dark:hover:bg-gray-700/50"><div class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-500 transition-colors dark:bg-gray-700 dark:text-gray-400">`);
				ssrRenderVNode(_push, createVNode(resolveDynamicComponent(card.icon), { class: "h-5 w-5" }, null), _parent);
				_push(`</div><h3 class="mb-1 text-sm font-medium text-gray-900 dark:text-gray-100">${ssrInterpolate(card.title)}</h3><p class="text-sm text-gray-400 dark:text-gray-500">${ssrInterpolate(card.description)}</p></div>`);
			});
			_push(`<!--]--></div></div>`);
		};
	}
});
//#endregion
//#region resources/js/pages/index.vue
var _sfc_setup = index_vue_vue_type_script_setup_true_lang_default.setup;
index_vue_vue_type_script_setup_true_lang_default.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/pages/index.vue");
	return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
var pages_default = index_vue_vue_type_script_setup_true_lang_default;
//#endregion
export { pages_default as default };

//# sourceMappingURL=pages-DS_GpRTf.js.map