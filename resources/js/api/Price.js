import Client from '../plugins/axios'
const resource = '/api';

export function filterPrice(data) {
    return Client({
        url: resource + '/price',
        method: 'get',
        params: data
    })
}
export function getPrice() {
    return Client({
        url: resource + '/price',
        method: 'get',
    })
}
export function createPrice(data) {
    return Client({
        url: resource + '/price',
        method: 'post',
        params: data
    })
}
export function updatePrice(id, data) {
    return Client({
        url: resource + '/price/' + id,
        method: 'put',
        params: data
    })
}
export function deletePrice(id) {
    return Client({
        url: resource + '/price/' + id,
        method: 'delete',
    })
}