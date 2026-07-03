import { t as useLocale } from "./assets/useLocale-DzvATyP9.js";
import { Link, createInertiaApp, usePage } from "@inertiajs/vue3";
import { createNotivue } from "notivue";
import { computed, createApp, createBlock, createTextVNode, createVNode, defineComponent, h, mergeProps, openBlock, ref, resolveDynamicComponent, toDisplayString, unref, useSSRContext, watch, withCtx } from "vue";
import { ZiggyVue, route } from "ziggy-js";
import { renderToString, ssrInterpolate, ssrRenderAttrs, ssrRenderClass, ssrRenderComponent, ssrRenderList, ssrRenderSlot, ssrRenderStyle, ssrRenderVNode } from "vue/server-renderer";
import { RiArrowDownSLine, RiArrowLeftSLine, RiArrowRightSLine, RiBookOpenLine, RiCoinsLine, RiCommandLine, RiLayoutGridFill, RiMoneyDollarCircleLine, RiMoonLine, RiPresentationLine, RiSunLine, RiTeamLine, RiUser3Fill, RiUser3Line, RiUserLine } from "@remixicon/vue";
import createServer from "@inertiajs/vue3/server";
//#region resources/js/components/layouts/header.vue?vue&type=script&setup=true&lang.ts
var header_vue_vue_type_script_setup_true_lang_default = /*@__PURE__*/ defineComponent({
	__name: "header",
	__ssrInlineRender: true,
	setup(__props) {
		const { t } = useLocale();
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<header${ssrRenderAttrs(mergeProps({ class: "sticky top-0 z-10 flex h-14 items-center justify-end border-b border-gray-100 bg-white/70 px-8 backdrop-blur-lg dark:border-gray-800 dark:bg-gray-950/70" }, _attrs))}><div class="flex items-center gap-3"><span class="text-sm text-gray-400 dark:text-gray-500">${ssrInterpolate(unref(t)("jale.salmanova"))}</span><div class="flex h-7 w-7 items-center justify-center overflow-hidden rounded-full bg-gray-100 text-xs text-gray-500 dark:bg-gray-800 dark:text-gray-400">`);
			_push(ssrRenderComponent(unref(RiUser3Fill), { class: "h-3.5 w-3.5" }, null, _parent));
			_push(`</div></div></header>`);
		};
	}
});
//#endregion
//#region resources/js/components/layouts/header.vue
var _sfc_setup$2 = header_vue_vue_type_script_setup_true_lang_default.setup;
header_vue_vue_type_script_setup_true_lang_default.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/layouts/header.vue");
	return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
var header_default = header_vue_vue_type_script_setup_true_lang_default;
//#endregion
//#region resources/js/composables/useDarkMode.ts
var STORAGE_KEY = "korpus-theme";
var isBrowser = typeof window !== "undefined";
function getInitialValue() {
	if (!isBrowser) return false;
	const stored = localStorage.getItem(STORAGE_KEY);
	if (stored !== null) return stored === "dark";
	return window.matchMedia("(prefers-color-scheme: dark)").matches;
}
function applyDark(val) {
	if (!isBrowser) return;
	document.documentElement.classList.toggle("dark", val);
}
var isDark = ref(getInitialValue());
applyDark(isDark.value);
watch(isDark, (val) => {
	if (!isBrowser) return;
	localStorage.setItem(STORAGE_KEY, val ? "dark" : "light");
	applyDark(val);
});
function useDarkMode() {
	return {
		isDark,
		toggle() {
			isDark.value = !isDark.value;
		}
	};
}
//#endregion
//#region resources/js/components/layouts/sidebar.vue?vue&type=script&setup=true&lang.ts
var sidebar_vue_vue_type_script_setup_true_lang_default = /*@__PURE__*/ defineComponent({
	__name: "sidebar",
	__ssrInlineRender: true,
	props: {
		activeMenu: {},
		collapsed: { type: Boolean }
	},
	emits: ["update:activeMenu", "update:collapsed"],
	setup(__props, { emit: __emit }) {
		const props = __props;
		const { isDark, toggle: toggleDark } = useDarkMode();
		const { locale: currentLocale } = useLocale();
		const page = usePage();
		const menuItems = computed(() => page.props.menus || []);
		const openDropdowns = ref([]);
		const iconMap = {
			RiLayoutGridFill,
			RiTeamLine,
			RiUserLine,
			RiBookOpenLine,
			RiMoneyDollarCircleLine,
			RiCommandLine,
			RiCoinsLine,
			RiPresentationLine,
			RiUser3Line
		};
		const resolveIcon = (name) => {
			return iconMap[name ?? ""] || RiCommandLine;
		};
		const isMenuActive = (item) => {
			if (props.activeMenu === item.id) return true;
			if (item.children && item.children.length > 0) return item.children.some((child) => child.id === props.activeMenu);
			return false;
		};
		watch(() => props.activeMenu, (newActiveId) => {
			if (!newActiveId) return;
			menuItems.value.forEach((item) => {
				if (item.children && item.children.length > 0) {
					if (item.children.some((child) => child.id === newActiveId) && !openDropdowns.value.includes(item.id)) openDropdowns.value.push(item.id);
				}
			});
		}, { immediate: true });
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<aside${ssrRenderAttrs(mergeProps({ class: ["sticky top-0 flex h-screen flex-col justify-between border-r border-gray-100 bg-white transition-all duration-300 dark:border-gray-900 dark:bg-gray-950", __props.collapsed ? "w-16" : "w-56"] }, _attrs))}><div><div class="${ssrRenderClass(["flex items-center py-6", __props.collapsed ? "justify-center" : "px-6"])}"><div class="flex items-center gap-2.5 font-semibold text-[#2B4CDE]"><div class="flex size-8 items-center justify-center rounded-lg bg-[#2B4CDE] text-white">`);
			_push(ssrRenderComponent(unref(RiCommandLine), { class: "h-4 w-4" }, null, _parent));
			_push(`</div><span class="text-sm tracking-tight" style="${ssrRenderStyle(!__props.collapsed ? null : { display: "none" })}">Korpus</span></div></div><div class="mx-6 mb-4 h-px bg-gray-100 dark:bg-gray-800" style="${ssrRenderStyle(!__props.collapsed ? null : { display: "none" })}"></div><nav class="space-y-1 px-3"><!--[-->`);
			ssrRenderList(menuItems.value, (item) => {
				_push(`<div class="space-y-0.5">`);
				if (!item?.children?.length) _push(ssrRenderComponent(unref(Link), {
					class: ["relative flex w-full cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm font-medium", unref(route)().current() === item.route ? "bg-blue-50 text-[#2B4CDE] dark:bg-blue-950 dark:text-blue-400" : "text-gray-500 transition-all duration-300 hover:bg-gray-50 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-900 dark:hover:text-gray-300"],
					href: unref(route)(item.route)
				}, {
					default: withCtx((_, _push, _parent, _scopeId) => {
						if (_push) {
							ssrRenderVNode(_push, createVNode(resolveDynamicComponent(resolveIcon(item.icon)), { class: "size-4 shrink-0" }, null), _parent, _scopeId);
							_push(` ${ssrInterpolate(item.translations[unref(currentLocale)]?.title)}`);
						} else return [(openBlock(), createBlock(resolveDynamicComponent(resolveIcon(item.icon)), { class: "size-4 shrink-0" })), createTextVNode(" " + toDisplayString(item.translations[unref(currentLocale)]?.title), 1)];
					}),
					_: 2
				}, _parent));
				else {
					_push(`<div class="${ssrRenderClass([
						"relative flex w-full cursor-pointer items-center rounded-lg px-3 py-2.5 text-left text-sm font-medium transition-all duration-300",
						isMenuActive(item) ? "bg-blue-50 text-[#2B4CDE] dark:bg-blue-950 dark:text-blue-400" : "text-gray-500 hover:bg-gray-50 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-900 dark:hover:text-gray-300",
						__props.collapsed ? "justify-center" : "gap-3"
					])}"><div class="${ssrRenderClass(isMenuActive(item) ? "text-[#2B4CDE] dark:text-blue-400" : "text-gray-400 dark:text-gray-500")}">`);
					ssrRenderVNode(_push, createVNode(resolveDynamicComponent(resolveIcon(item.icon)), { class: "size-4 shrink-0" }, null), _parent);
					_push(`</div><span class="flex-1 truncate text-left" style="${ssrRenderStyle(!__props.collapsed ? null : { display: "none" })}">${ssrInterpolate(item.translations[unref(currentLocale)]?.title || "Menu")}</span>`);
					if (item.children && item.children.length > 0 && !__props.collapsed) _push(ssrRenderComponent(unref(RiArrowDownSLine), { class: ["size-3 text-gray-400 transition-transform duration-200", openDropdowns.value.includes(item.id) ? "rotate-180 text-[#2B4CDE] dark:text-blue-400" : ""] }, null, _parent));
					else _push(`<!---->`);
					_push(`</div>`);
				}
				if (item.children && item.children.length > 0 && !__props.collapsed && openDropdowns.value.includes(item.id)) {
					_push(`<div class="relative ml-5 space-y-0.5 border-l border-gray-200 pl-6 dark:border-gray-800"><!--[-->`);
					ssrRenderList(item.children, (child) => {
						_push(ssrRenderComponent(unref(Link), {
							key: child.id,
							class: ["relative flex w-full items-center rounded-lg px-3 py-2 text-left text-xs font-medium transition-all", __props.activeMenu === child.id ? "font-semibold text-[#2B4CDE] dark:text-blue-400" : "text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200"],
							href: unref(route)(child.route)
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(`<span class="absolute top-1/2 -left-6.25 flex -translate-y-1/2 items-center"${_scopeId}><span class="size-1.5 rounded-full border border-gray-300 bg-white dark:border-gray-700 dark:bg-gray-950"${_scopeId}></span></span><span class="truncate"${_scopeId}>${ssrInterpolate(child.translations[unref(currentLocale)]?.title || "Submenu")}</span>`);
								else return [createVNode("span", { class: "absolute top-1/2 -left-6.25 flex -translate-y-1/2 items-center" }, [createVNode("span", { class: "size-1.5 rounded-full border border-gray-300 bg-white dark:border-gray-700 dark:bg-gray-950" })]), createVNode("span", { class: "truncate" }, toDisplayString(child.translations[unref(currentLocale)]?.title || "Submenu"), 1)];
							}),
							_: 2
						}, _parent));
					});
					_push(`<!--]--></div>`);
				} else _push(`<!---->`);
				_push(`</div>`);
			});
			_push(`<!--]--></nav></div><div class="px-6 py-5" style="${ssrRenderStyle(!__props.collapsed ? null : { display: "none" })}"><div class="flex items-center gap-1"><button class="flex size-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-gray-300">`);
			if (unref(isDark)) _push(ssrRenderComponent(unref(RiSunLine), { class: "h-4 w-4" }, null, _parent));
			else _push(ssrRenderComponent(unref(RiMoonLine), { class: "h-4 w-4" }, null, _parent));
			_push(`</button><button class="rounded-lg px-3 py-1.5 text-sm font-medium text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-gray-300">${ssrInterpolate(unref(currentLocale).toUpperCase())}</button></div></div><button class="absolute top-1/2 -right-3 z-20 flex size-6 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-400 shadow-sm hover:border-[#2B4CDE] hover:text-[#2B4CDE] dark:border-gray-700 dark:bg-gray-950 dark:text-gray-500 dark:hover:border-blue-400 dark:hover:text-blue-400">`);
			_push(ssrRenderComponent(unref(RiArrowLeftSLine), {
				style: !__props.collapsed ? null : { display: "none" },
				class: "size-3"
			}, null, _parent));
			_push(ssrRenderComponent(unref(RiArrowRightSLine), {
				style: __props.collapsed ? null : { display: "none" },
				class: "size-3"
			}, null, _parent));
			_push(`</button></aside>`);
		};
	}
});
//#endregion
//#region resources/js/components/layouts/sidebar.vue
var _sfc_setup$1 = sidebar_vue_vue_type_script_setup_true_lang_default.setup;
sidebar_vue_vue_type_script_setup_true_lang_default.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/layouts/sidebar.vue");
	return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
var sidebar_default = sidebar_vue_vue_type_script_setup_true_lang_default;
//#endregion
//#region resources/js/layouts/default.vue?vue&type=script&setup=true&lang.ts
var default_vue_vue_type_script_setup_true_lang_default = /*@__PURE__*/ defineComponent({
	__name: "default",
	__ssrInlineRender: true,
	setup(__props) {
		const currentMenu = ref(null);
		const isCollapsed = ref(false);
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "flex min-h-screen bg-gray-50 text-gray-900 antialiased dark:bg-gray-900 dark:text-gray-100" }, _attrs))}>`);
			_push(ssrRenderComponent(sidebar_default, {
				activeMenu: currentMenu.value,
				"onUpdate:activeMenu": ($event) => currentMenu.value = $event,
				collapsed: isCollapsed.value,
				"onUpdate:collapsed": ($event) => isCollapsed.value = $event
			}, null, _parent));
			_push(`<div class="flex min-h-screen flex-1 flex-col">`);
			_push(ssrRenderComponent(header_default, null, null, _parent));
			_push(`<main class="flex-1 p-8">`);
			ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
			_push(`</main></div></div>`);
		};
	}
});
//#endregion
//#region resources/js/layouts/default.vue
var _sfc_setup = default_vue_vue_type_script_setup_true_lang_default.setup;
default_vue_vue_type_script_setup_true_lang_default.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/layouts/default.vue");
	return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
var default_default = default_vue_vue_type_script_setup_true_lang_default;
//#endregion
//#region resources/js/app.ts
var appName = "Laravel";
var notivue = createNotivue({
	position: "top-right",
	limit: 5
});
var render = await createInertiaApp({
	resolve: async (name, page) => {
		const pages = /* #__PURE__ */ Object.assign({
			"./pages/index.vue": () => import("./assets/pages-DS_GpRTf.js"),
			"./pages/menu/create.vue": () => import("./assets/create-BGvKjZ_Y.js"),
			"./pages/menu/index.vue": () => import("./assets/menu-oZY-Dzmr.js")
		});
		const module = await (pages[`./pages/${name}.vue`] || pages[`./Pages/${name}.vue`])?.();
		if (!module) throw new Error(`Page not found: ${name}`);
		return module.default ?? module;
	},
	title: (title) => title ? `${title} - ${appName}` : appName,
	layout: () => default_default,
	progress: { color: "#4575AF" },
	setup({ el, App, props, plugin }) {
		createApp({ render: () => h(App, props) }).use(plugin).use(ZiggyVue).use(notivue).mount(el);
	}
});
var renderPage = (page) => render(page, renderToString);
createServer(renderPage);
//#endregion
export { renderPage as default };

//# sourceMappingURL=app.js.map