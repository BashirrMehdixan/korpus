import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
import menus from './menus'
/**
* @see \App\Http\Controllers\Front\IndexController::index
 * @see app/Http/Controllers/Front/IndexController.php:10
 * @route '/{locale}'
 */
export const index = (args: { locale: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/{locale}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\IndexController::index
 * @see app/Http/Controllers/Front/IndexController.php:10
 * @route '/{locale}'
 */
index.url = (args: { locale: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { locale: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    locale: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        locale: args.locale,
                }

    return index.definition.url
            .replace('{locale}', parsedArgs.locale.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\IndexController::index
 * @see app/Http/Controllers/Front/IndexController.php:10
 * @route '/{locale}'
 */
index.get = (args: { locale: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Front\IndexController::index
 * @see app/Http/Controllers/Front/IndexController.php:10
 * @route '/{locale}'
 */
index.head = (args: { locale: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(args, options),
    method: 'head',
})
const front = {
    index: Object.assign(index, index),
menus: Object.assign(menus, menus),
}

export default front