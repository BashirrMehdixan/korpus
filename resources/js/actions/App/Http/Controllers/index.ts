import Api from './Api'
import Front from './Front'
const Controllers = {
    Api: Object.assign(Api, Api),
Front: Object.assign(Front, Front),
}

export default Controllers