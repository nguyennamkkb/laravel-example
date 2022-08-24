import Client from '../plugins/axios'
const resource = '/api';

export function getCustomerType(data) {
    return Client({
        url: resource + '/customertype',
        method: 'get',
        params: data
    })
}
export function createCustomerType(data) {
    return Client({
        url: resource + '/customertype',
        method: 'post',
        params: data
    })
}
export function updateCustomerType(id, data) {
    return Client({
        url: resource + '/customertype/' + id,
        method: 'put',
        params: data
    })
}
export function deleteCustomerType(id) {
    return Client({
        url: resource + '/customertype/' + id,
        method: 'delete',
    })
}