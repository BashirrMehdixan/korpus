import IndexController from './IndexController'
import MenuController from './MenuController'
const Front = {
    IndexController: Object.assign(IndexController, IndexController),
MenuController: Object.assign(MenuController, MenuController),
}

export default Front