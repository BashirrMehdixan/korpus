import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Front\MenuController::index
 * @see app/Http/Controllers/Front/MenuController.php:15
 * @route '/{locale}/menus'
 */
export const index = (args: { locale: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/{locale}/menus',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\MenuController::index
 * @see app/Http/Controllers/Front/MenuController.php:15
 * @route '/{locale}/menus'
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
* @see \App\Http\Controllers\Front\MenuController::index
 * @see app/Http/Controllers/Front/MenuController.php:15
 * @route '/{locale}/menus'
 */
index.get = (args: { locale: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Front\MenuController::index
 * @see app/Http/Controllers/Front/MenuController.php:15
 * @route '/{locale}/menus'
 */
index.head = (args: { locale: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Front\MenuController::create
 * @see app/Http/Controllers/Front/MenuController.php:101
 * @route '/{locale}/menus/create'
 */
export const create = (args: { locale: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/{locale}/menus/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\MenuController::create
 * @see app/Http/Controllers/Front/MenuController.php:101
 * @route '/{locale}/menus/create'
 */
create.url = (args: { locale: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return create.definition.url
            .replace('{locale}', parsedArgs.locale.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\MenuController::create
 * @see app/Http/Controllers/Front/MenuController.php:101
 * @route '/{locale}/menus/create'
 */
create.get = (args: { locale: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Front\MenuController::create
 * @see app/Http/Controllers/Front/MenuController.php:101
 * @route '/{locale}/menus/create'
 */
create.head = (args: { locale: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Front\MenuController::store
 * @see app/Http/Controllers/Front/MenuController.php:63
 * @route '/{locale}/menus'
 */
export const store = (args: { locale: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/{locale}/menus',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Front\MenuController::store
 * @see app/Http/Controllers/Front/MenuController.php:63
 * @route '/{locale}/menus'
 */
store.url = (args: { locale: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return store.definition.url
            .replace('{locale}', parsedArgs.locale.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\MenuController::store
 * @see app/Http/Controllers/Front/MenuController.php:63
 * @route '/{locale}/menus'
 */
store.post = (args: { locale: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Front\MenuController::edit
 * @see app/Http/Controllers/Front/MenuController.php:31
 * @route '/{locale}/menus/{menu}/edit'
 */
export const edit = (args: { locale: string | number, menu: string | { id: string } } | [locale: string | number, menu: string | { id: string } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/{locale}/menus/{menu}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\MenuController::edit
 * @see app/Http/Controllers/Front/MenuController.php:31
 * @route '/{locale}/menus/{menu}/edit'
 */
edit.url = (args: { locale: string | number, menu: string | { id: string } } | [locale: string | number, menu: string | { id: string } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
                    locale: args[0],
                    menu: args[1],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        locale: args.locale,
                                menu: typeof args.menu === 'object'
                ? args.menu.id
                : args.menu,
                }

    return edit.definition.url
            .replace('{locale}', parsedArgs.locale.toString())
            .replace('{menu}', parsedArgs.menu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\MenuController::edit
 * @see app/Http/Controllers/Front/MenuController.php:31
 * @route '/{locale}/menus/{menu}/edit'
 */
edit.get = (args: { locale: string | number, menu: string | { id: string } } | [locale: string | number, menu: string | { id: string } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Front\MenuController::edit
 * @see app/Http/Controllers/Front/MenuController.php:31
 * @route '/{locale}/menus/{menu}/edit'
 */
edit.head = (args: { locale: string | number, menu: string | { id: string } } | [locale: string | number, menu: string | { id: string } ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Front\MenuController::update
 * @see app/Http/Controllers/Front/MenuController.php:63
 * @route '/{locale}/menus/{menu}'
 */
export const update = (args: { locale: string | number, menu: string | { id: string } } | [locale: string | number, menu: string | { id: string } ], options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/{locale}/menus/{menu}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Front\MenuController::update
 * @see app/Http/Controllers/Front/MenuController.php:63
 * @route '/{locale}/menus/{menu}'
 */
update.url = (args: { locale: string | number, menu: string | { id: string } } | [locale: string | number, menu: string | { id: string } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
                    locale: args[0],
                    menu: args[1],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        locale: args.locale,
                                menu: typeof args.menu === 'object'
                ? args.menu.id
                : args.menu,
                }

    return update.definition.url
            .replace('{locale}', parsedArgs.locale.toString())
            .replace('{menu}', parsedArgs.menu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\MenuController::update
 * @see app/Http/Controllers/Front/MenuController.php:63
 * @route '/{locale}/menus/{menu}'
 */
update.put = (args: { locale: string | number, menu: string | { id: string } } | [locale: string | number, menu: string | { id: string } ], options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Front\MenuController::destroy
 * @see app/Http/Controllers/Front/MenuController.php:116
 * @route '/{locale}/menus/{menu}'
 */
export const destroy = (args: { locale: string | number, menu: string | { id: string } } | [locale: string | number, menu: string | { id: string } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/{locale}/menus/{menu}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Front\MenuController::destroy
 * @see app/Http/Controllers/Front/MenuController.php:116
 * @route '/{locale}/menus/{menu}'
 */
destroy.url = (args: { locale: string | number, menu: string | { id: string } } | [locale: string | number, menu: string | { id: string } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
                    locale: args[0],
                    menu: args[1],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        locale: args.locale,
                                menu: typeof args.menu === 'object'
                ? args.menu.id
                : args.menu,
                }

    return destroy.definition.url
            .replace('{locale}', parsedArgs.locale.toString())
            .replace('{menu}', parsedArgs.menu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\MenuController::destroy
 * @see app/Http/Controllers/Front/MenuController.php:116
 * @route '/{locale}/menus/{menu}'
 */
destroy.delete = (args: { locale: string | number, menu: string | { id: string } } | [locale: string | number, menu: string | { id: string } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const menus = {
    index: Object.assign(index, index),
create: Object.assign(create, create),
store: Object.assign(store, store),
edit: Object.assign(edit, edit),
update: Object.assign(update, update),
destroy: Object.assign(destroy, destroy),
}

export default menus