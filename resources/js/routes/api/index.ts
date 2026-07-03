import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Api\MenuController::menus
 * @see app/Http/Controllers/Api/MenuController.php:11
 * @route '/api/menus'
 */
export const menus = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: menus.url(options),
    method: 'get',
})

menus.definition = {
    methods: ["get","head"],
    url: '/api/menus',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\MenuController::menus
 * @see app/Http/Controllers/Api/MenuController.php:11
 * @route '/api/menus'
 */
menus.url = (options?: RouteQueryOptions) => {
    return menus.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\MenuController::menus
 * @see app/Http/Controllers/Api/MenuController.php:11
 * @route '/api/menus'
 */
menus.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: menus.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Api\MenuController::menus
 * @see app/Http/Controllers/Api/MenuController.php:11
 * @route '/api/menus'
 */
menus.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: menus.url(options),
    method: 'head',
})
const api = {
    menus: Object.assign(menus, menus),
}

export default api