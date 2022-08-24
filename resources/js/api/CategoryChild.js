import Client from '../plugins/axios'
const resource = '/api';

export function getCategoryChild(data) {
    return Client({
        url: resource + '/categoryChild',
        method: 'get',
        params: data
    })
}
export function getCategoryChildbyCategoryId(data) {
    return Client({
        url: resource + '/categoryChildbyid',
        method: 'get',
        params: data
    })
}
export function createCategoryChild(data) {
    return Client({
        url: resource + '/categoryChild',
        method: 'post',
        data
    })
}
export function updateCategoryChild(id, data) {
    return Client({
        url: resource + '/categoryChild/' + id,
        method: 'put',
        data
    })
}
export function deleteCategoryChild(id) {
    return Client({
        url: resource + '/categoryChild/' + id,
        method: 'delete',
    })
}