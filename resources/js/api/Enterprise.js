import Client from '../plugins/axios'
const resource = '/api';

export function getEnterprise(data) {
    return Client({
        url: resource + '/enterprise',
        method: 'get',
        params: data
    })
}
export function createEnterprise() {
    return Client({
        url: resource + '/enterprise',
        method: 'post',
    })
}
export function updateEnterprise(id, data) {
    return Client({
        url: resource + '/enterprise/' + id,
        method: 'put',
        params: data
    })
}
export function deleteEnterprise(id) {
    return Client({
        url: resource + '/enterprise/' + id,
        method: 'delete',
    })
}