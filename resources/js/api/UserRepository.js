import Client from '../plugins/axios'
const resource = '/api';

export function filterUser(data) {
    return Client({
        url: resource + '/users',
        method: 'get',
        params: data
    })
}
export function getUser() {
    return Client({
        url: resource + '/users',
        method: 'get',
    })
}
export function createUser(data) {
    return Client({
        url: resource + '/users',
        method: 'post',
        params: data
    })
}
export function updateUser(id, data) {
    return Client({
        url: resource + '/users/' + id,
        method: 'put',
        params: data
    })
}
export function deleteUser(id) {
    return Client({
        url: resource + '/users/' + id,
        method: 'delete',
    })
}