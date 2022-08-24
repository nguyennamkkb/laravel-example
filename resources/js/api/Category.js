import Client from '../plugins/axios'
const resource = '/api';

export function getCategory(data) {
    return Client({
        url: resource + '/category',
        method: 'get',
        params: data,

    })
}
export function createCategory(data) {
    return Client({
        url: resource + '/category',
        method: 'post',
        params: data
    })
}
export function updateCategory(id, data) {
    return Client({
        url: resource + '/category/' + id,
        method: 'put',
        params: data
    })
}
export function deleteCategory(id) {
    return Client({
        url: resource + '/category/' + id,
        method: 'delete',
    })
}