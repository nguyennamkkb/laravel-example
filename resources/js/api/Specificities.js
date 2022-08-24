import Client from '../plugins/axios'
const resource = '/api';


export function getSpecificities(data) {
    return Client({
        url: resource + '/specificities',
        method: 'get',
        params: data
    })
}
export function createSpecificities(data) {
    return Client({
        url: resource + '/specificities',
        method: 'post',
        params: data
    })
}
export function updateSpecificities(id, data) {
    return Client({
        url: resource + '/specificities/' + id,
        method: 'put',
        params: data
    })
}
export function deleteSpecificities(id) {
    return Client({
        url: resource + '/specificities/' + id,
        method: 'delete',
    })
}