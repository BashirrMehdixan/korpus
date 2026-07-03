import { t as useLocale } from "./useLocale-DzvATyP9.js";
import { Link } from "@inertiajs/vue3";
import { createTextVNode, createVNode, defineComponent, mergeProps, resolveDynamicComponent, unref, useSSRContext, withCtx } from "vue";
import { route } from "ziggy-js";
import { ssrInterpolate, ssrRenderAttrs, ssrRenderComponent, ssrRenderList, ssrRenderVNode } from "vue/server-renderer";
import * as RemixIcons from "@remixicon/vue";
import { RiAddLine, RiDeleteBin6Line, RiEditLine, RiQuestionLine } from "@remixicon/vue";
//#region resources/js/pages/menu/index.vue?vue&type=script&setup=true&lang.ts
var index_vue_vue_type_script_setup_true_lang_default = /*@__PURE__*/ defineComponent({
	__name: "index",
	__ssrInlineRender: true,
	props: { menus: {} },
	setup(__props) {
		const { rn } = useLocale();
		function getIconComponent(iconName) {
			if (iconName && iconName in RemixIcons) return RemixIcons[iconName];
			return RiQuestionLine;
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "mx-auto max-w-6xl" }, _attrs))}><div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"><div><h1 class="text-2xl font-bold text-gray-950 dark:text-gray-50"> Menyular </h1><p class="mt-1 text-sm text-gray-400 dark:text-gray-500"> Sistem naviqasiyasında istifadə olunan bütün menyu elementlərinin siyahısı. </p></div><div>`);
			_push(ssrRenderComponent(unref(Link), {
				href: unref(route)("front.menus.create"),
				class: "inline-flex items-center gap-2 rounded-xl bg-[#2B4CDE] px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/10 transition-all hover:bg-[#1a3bb8] hover:shadow-lg hover:shadow-blue-500/20 active:scale-[0.98] dark:bg-sky-500 dark:shadow-sky-500/5 dark:hover:bg-sky-600"
			}, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(unref(RiAddLine), { class: "size-4" }, null, _parent, _scopeId));
						_push(` Yeni Menu `);
					} else return [createVNode(unref(RiAddLine), { class: "size-4" }), createTextVNode(" Yeni Menu ")];
				}),
				_: 1
			}, _parent));
			_push(`</div></div><div class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900"><div class="overflow-x-auto"><table class="w-full border-collapse text-left"><thead><tr class="border-b border-gray-100 bg-gray-50/50 dark:border-gray-800 dark:bg-gray-900/50"><th class="w-16 px-6 py-4 text-xs font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500"> # </th><th class="px-6 py-4 text-xs font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500"> Başlıq (AZ) </th><th class="px-6 py-4 text-xs font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500"> Başlıq (EN) </th><th class="px-6 py-4 text-xs font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500"> Başlıq (RU) </th><th class="w-24 px-6 py-4 text-center text-xs font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500"> İkon </th><th class="w-24 px-6 py-4 text-center text-xs font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500"> Sıra </th><th class="w-32 px-6 py-4 text-right text-xs font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500"> Fəaliyyətlər </th></tr></thead><tbody class="divide-y divide-gray-50 dark:divide-gray-800/60"><!--[-->`);
			ssrRenderList(__props.menus, (menu) => {
				_push(`<tr class="group transition-colors hover:bg-gray-50/50 dark:hover:bg-gray-800/30"><td class="px-6 py-4.5 text-sm font-medium text-gray-400 dark:text-gray-500">${ssrInterpolate(menu.id)}</td><td class="px-6 py-4.5 text-sm font-semibold text-gray-950 dark:text-gray-100">${ssrInterpolate(menu.translations.az?.title ?? "-")}</td><td class="px-6 py-4.5 text-sm text-gray-600 dark:text-gray-400">${ssrInterpolate(menu.translations.en?.title ?? "-")}</td><td class="px-6 py-4.5 text-sm text-gray-600 dark:text-gray-400">${ssrInterpolate(menu.translations.ru?.title ?? "-")}</td><td class="px-6 py-4.5 text-center"><div class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gray-50 text-gray-500 transition-colors group-hover:bg-[#EEF2FF] group-hover:text-[#2B4CDE] dark:bg-gray-800 dark:text-gray-400 dark:group-hover:bg-sky-950/50 dark:group-hover:text-sky-400">`);
				ssrRenderVNode(_push, createVNode(resolveDynamicComponent(getIconComponent(menu.icon)), { class: "h-5 w-5" }, null), _parent);
				_push(`</div></td><td class="px-6 py-4.5 text-center"><span class="inline-flex items-center justify-center rounded-md bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-600 dark:bg-gray-800 dark:text-gray-400">${ssrInterpolate(menu.order)}</span></td><td class="px-6 py-4.5 text-right"><div class="flex items-center justify-end gap-2">`);
				_push(ssrRenderComponent(unref(Link), {
					href: unref(route)("front.menus.edit", menu.id),
					class: "rounded-lg p-2 text-gray-500 transition-all hover:bg-gray-50 hover:text-[#2B4CDE] dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-sky-400",
					title: "Redaktə et"
				}, {
					default: withCtx((_, _push, _parent, _scopeId) => {
						if (_push) _push(ssrRenderComponent(unref(RiEditLine), { class: "h-4 w-4" }, null, _parent, _scopeId));
						else return [createVNode(unref(RiEditLine), { class: "h-4 w-4" })];
					}),
					_: 2
				}, _parent));
				_push(`<button class="rounded-lg p-2 text-gray-400 transition-all hover:bg-red-50 hover:text-red-600 dark:text-gray-500 dark:hover:bg-red-950/30 dark:hover:text-red-400" title="Sil">`);
				_push(ssrRenderComponent(unref(RiDeleteBin6Line), { class: "h-4 w-4" }, null, _parent));
				_push(`</button></div></td></tr>`);
			});
			_push(`<!--]-->`);
			if (__props.menus.length === 0) _push(`<tr><td class="px-6 py-12 text-center text-sm text-gray-400 dark:text-gray-500" colspan="7"> Siyahıda heç bir menyu elementi tapılmadı. </td></tr>`);
			else _push(`<!---->`);
			_push(`</tbody></table></div></div></div>`);
		};
	}
});
//#endregion
//#region resources/js/pages/menu/index.vue
var _sfc_setup = index_vue_vue_type_script_setup_true_lang_default.setup;
index_vue_vue_type_script_setup_true_lang_default.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/pages/menu/index.vue");
	return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
var menu_default = index_vue_vue_type_script_setup_true_lang_default;
//#endregion
export { menu_default as default };

//# sourceMappingURL=menu-oZY-Dzmr.js.map