import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
//#region resources/js/composables/useLocale.ts
function useLocale() {
	const page = usePage();
	const locale = computed(() => page.props.locale ?? "az");
	function t(key) {
		return page.props.translations?.[key] ?? key;
	}
	function localeUrl(target) {
		const current = window.location.pathname.replace(/^\/?(az|en|ru)\/?/, "");
		return target === "az" ? `/${current}` : `/${target}/${current}`;
	}
	function rn(name) {
		const currentLoc = page.props.locale ?? "az";
		return `${currentLoc === "az" ? "front" : currentLoc}.${name.replace(/^front\./, "")}`;
	}
	return {
		locale,
		availableLocales: page.props.availableLocales ?? [
			"az",
			"en",
			"ru"
		],
		t,
		localeUrl,
		rn
	};
}
//#endregion
export { useLocale as t };

//# sourceMappingURL=useLocale-DzvATyP9.js.map