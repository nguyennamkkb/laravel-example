import Client from '../plugins/axios'
const resource = '/api/example'

export function getExample (data) {
  return Client({
    url: resource,
    method: 'get',
    params: data
  })
}
export function createExample (data) {
  return Client({
    url: resource,
    method: 'post',
    params: data
  })
}
export function updateExample (id, data) {
  return Client({
    url: resource + '/' + id,
    method: 'put',
    params: data
  })
}
export function deleteExample (id) {
  return Client({
    url: resource + '/' + id,
    method: 'delete'
  })
}
