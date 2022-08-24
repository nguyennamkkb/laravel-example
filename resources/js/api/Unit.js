import Client from '../plugins/axios'
const resource = '/api';

export function getUnit(data) {
    return Client({
        url: resource + '/unit',
        method: 'get',
        params: data
    })
}
export function createUnit(data) {
    return Client({
        url: resource + '/unit',
        method: 'post',
        params: data
    })
}
export function updateUnit(id, data) {
    return Client({
        url: resource + '/unit/' + id,
        method: 'put',
        params: data
    })
}
export function deleteUnit(id) {
    return Client({
        url: resource + '/unit/' + id,
        method: 'delete',
    })
}