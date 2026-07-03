import { t as useLocale } from "./useLocale-DzvATyP9.js";
import { Link } from "@inertiajs/vue3";
import { computed, createTextVNode, createVNode, defineComponent, mergeProps, reactive, unref, useSSRContext, withCtx } from "vue";
import { route } from "ziggy-js";
import { ssrIncludeBooleanAttr, ssrInterpolate, ssrLooseContain, ssrRenderAttr, ssrRenderAttrs, ssrRenderComponent, ssrRenderList } from "vue/server-renderer";
import { RiArrowLeftSLine, RiCommandLine, RiLink, RiTranslate2 } from "@remixicon/vue";
//#region resources/js/pages/menu/create.vue?vue&type=script&setup=true&lang.ts
var create_vue_vue_type_script_setup_true_lang_default = /*@__PURE__*/ defineComponent({
	__name: "create",
	__ssrInlineRender: true,
	props: { menu: {} },
	setup(__props) {
		const { rn } = useLocale();
		const props = __props;
		const locales = {
			az: "AZ",
			en: "EN",
			ru: "RU"
		};
		const isEdit = computed(() => !!props.menu);
		const form = reactive({
			icon: props.menu?.icon ?? "",
			route: props.menu?.route ?? "",
			order: props.menu?.order ?? 0,
			status: props.menu?.status ?? false,
			translations: Object.keys(locales).reduce((acc, key) => {
				acc[key] = props.menu?.translations?.[key] ?? "";
				return acc;
			}, {})
		});
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "mx-auto max-w-5xl" }, _attrs))}><div class="mb-8">`);
			_push(ssrRenderComponent(unref(Link), {
				href: unref(route)(unref(rn)("menus.index")),
				class: "mb-3 inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 transition-colors hover:text-[#2B4CDE] dark:text-gray-400 dark:hover:text-sky-400"
			}, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(unref(RiArrowLeftSLine), { class: "h-4 w-4" }, null, _parent, _scopeId));
						_push(` Geri qayıt `);
					} else return [createVNode(unref(RiArrowLeftSLine), { class: "h-4 w-4" }), createTextVNode(" Geri qayıt ")];
				}),
				_: 1
			}, _parent));
			_push(`<h1 class="text-2xl font-bold text-gray-950 dark:text-gray-50">${ssrInterpolate(isEdit.value ? "Menyu Redaktə Et" : "Yeni Menyu Elementi")}</h1><p class="mt-1 text-sm text-gray-400 dark:text-gray-500">${ssrInterpolate(isEdit.value ? "Mövcud menyu elementinin parametrlərini və tərcümələrini yeniləyin." : "Sistem naviqasiyası üçün yeni bir keçid və alt mühit yaradın.")}</p></div><form class="grid grid-cols-1 gap-8 lg:grid-cols-3"><div class="space-y-6 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2 dark:border-gray-800 dark:bg-gray-900"><div class="grid grid-cols-1 gap-5 md:grid-cols-2"><div><label class="mb-2 block text-sm font-semibold text-gray-800 dark:text-gray-200">İkon (RemixIcon)</label><div class="relative flex items-center"><span class="absolute left-4 text-gray-400 dark:text-gray-500">`);
			_push(ssrRenderComponent(unref(RiCommandLine), { class: "h-5 w-5" }, null, _parent));
			_push(`</span><input${ssrRenderAttr("value", form.icon)} class="w-full rounded-xl border border-gray-200 py-3 pr-4 pl-11 text-sm transition-all outline-none focus:border-[#2B4CDE] focus:ring-2 focus:ring-[#2B4CDE]/10 dark:border-gray-700 dark:bg-gray-800/50 dark:text-gray-100 dark:focus:border-sky-500 dark:focus:ring-sky-500/10" placeholder="RiCommandLine"></div></div><div><label class="mb-2 block text-sm font-semibold text-gray-800 dark:text-gray-200">Route adı</label><div class="relative flex items-center"><span class="absolute left-4 text-gray-400 dark:text-gray-500">`);
			_push(ssrRenderComponent(unref(RiLink), { class: "h-5 w-5" }, null, _parent));
			_push(`</span><input${ssrRenderAttr("value", form.route)} class="w-full rounded-xl border border-gray-200 py-3 pr-4 pl-11 text-sm transition-all outline-none focus:border-[#2B4CDE] focus:ring-2 focus:ring-[#2B4CDE]/10 dark:border-gray-700 dark:bg-gray-800/50 dark:text-gray-100 dark:focus:border-sky-500 dark:focus:ring-sky-500/10" placeholder="index / menus.index"></div></div></div><div class="max-w-xs"><label class="mb-2 block text-sm font-semibold text-gray-800 dark:text-gray-200">Sıralama nömrəsi</label><input${ssrRenderAttr("value", form.order)} class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm transition-all outline-none focus:border-[#2B4CDE] focus:ring-2 focus:ring-[#2B4CDE]/10 dark:border-gray-700 dark:bg-gray-800/50 dark:text-gray-100 dark:focus:border-sky-500 dark:focus:ring-sky-500/10" min="0" type="number"></div><div class="pt-2"><label class="group inline-flex cursor-pointer items-center gap-3" for="status"><div class="relative"><input id="status"${ssrIncludeBooleanAttr(Array.isArray(form.status) ? ssrLooseContain(form.status, null) : form.status) ? " checked" : ""} class="peer sr-only" type="checkbox"><div class="peer h-6 w-11 rounded-full bg-gray-200 peer-checked:bg-[#2B4CDE] peer-focus:ring-2 peer-focus:ring-[#2B4CDE]/20 after:absolute after:top-0.5 after:left-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[&#39;&#39;] peer-checked:after:translate-x-full peer-checked:after:border-white dark:border-gray-600 dark:bg-gray-700 dark:peer-checked:bg-sky-500"></div></div><span class="text-sm font-medium text-gray-800 select-none dark:text-gray-200"> Bu menyu elementi sistemdə aktiv edilsin </span></label></div></div><div class="flex flex-col justify-between space-y-5 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900"><div><h3 class="mb-1 flex items-center gap-2 text-sm font-bold tracking-wider text-gray-950 uppercase dark:text-gray-50">`);
			_push(ssrRenderComponent(unref(RiTranslate2), { class: "h-4 w-4 text-[#2B4CDE] dark:text-sky-400" }, null, _parent));
			_push(` Tərcümələr </h3><p class="mb-5 text-xs text-gray-400 dark:text-gray-500"> Hər dilə uyğun müvafiq başlığı daxil edin. </p><div class="space-y-4"><!--[-->`);
			ssrRenderList(locales, (label, key) => {
				_push(`<div><label class="mb-1.5 block text-xs font-semibold text-gray-500 uppercase dark:text-gray-400"> Başlıq (${ssrInterpolate(label)}) </label><input${ssrRenderAttr("value", form.translations[key])}${ssrRenderAttr("placeholder", `Məs: Əsas Səhifə (${label})`)} class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm transition-all outline-none focus:border-[#2B4CDE] focus:ring-2 focus:ring-[#2B4CDE]/10 dark:border-gray-700 dark:bg-gray-800/50 dark:text-gray-100 dark:focus:border-sky-500 dark:focus:ring-sky-500/10"></div>`);
			});
			_push(`<!--]--></div></div><div class="border-t border-gray-50 pt-6 dark:border-gray-800/60"><button class="w-full rounded-xl bg-[#2B4CDE] px-6 py-3 text-sm font-semibold text-white shadow-md shadow-blue-500/10 transition-all hover:bg-[#1a3bb8] hover:shadow-lg hover:shadow-blue-500/20 active:scale-[0.98] dark:bg-sky-500 dark:shadow-sky-500/5 dark:hover:bg-sky-600" type="submit">${ssrInterpolate(isEdit.value ? "Dəyişiklikləri Yadda Saxla" : "Menyunu Yarat")}</button></div></div></form></div>`);
		};
	}
});
//#endregion
//#region resources/js/pages/menu/create.vue
var _sfc_setup = create_vue_vue_type_script_setup_true_lang_default.setup;
create_vue_vue_type_script_setup_true_lang_default.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/pages/menu/create.vue");
	return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
var create_default = create_vue_vue_type_script_setup_true_lang_default;
//#endregion
export { create_default as default };

//# sourceMappingURL=create-BGvKjZ_Y.js.map