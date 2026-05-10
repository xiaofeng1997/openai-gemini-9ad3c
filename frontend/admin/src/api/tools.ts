import request from '@/utils/request'

/***************************************************** 代码生成 ****************************************************/

/**
 * 获取代码生成列表
 * @param params
 * @returns
 */
export function getGenerateTableList(params: Record<string, any>) {
    return request.get(`generator/generator`, { params })
}

/**
 * 获取代码生成详情
 * @param id 代码生成id
 * @returns
 */
export function getGenerateTableInfo(id: number) {
    return request.get(`generator/generator/${ id }`);
}

/**
 * 添加代码生成
 * @param params
 * @returns
 */
export function addGenerateTable(params: Record<string, any>) {
    return request.post('generator/generator', params, { showSuccessMessage: true })
}

/**
 * 编辑代码生成
 * @param params
 */
export function editGenerateTable(params: Record<string, any>) {
    return request.put(`generator/generator/${ params.id }`, params, { showSuccessMessage: true })
}

/**
 * 删除代码生成
 * @param id
 * @returns
 */
export function deleteGenerateTable(id: number) {
    return request.delete(`generator/generator/${ id }`, { showSuccessMessage: true })
}

/**
 * 代码生成
 * @param params
 * @returns
 */
export function generateCreate(params: Record<string, any>) {
    return request.post(`generator/download`, params)
}

/**
 * 代码生成预览
 * @param id
 * @returns
 */
export function generatePreview(id: number) {
    return request.get(`generator/preview/${ id }`)
}

/**
 * 数据表
 */
export function generateTable() {
    return request.get(`generator/table`)
}

/**
 * 获取服务器环境配置
 */
export function getSystem() {
    return request.get(`sys/system`)
}

/**
 * 获取全部模型
 */
export function getGeneratorAllModel(params: any) {
    return request.get(`generator/all_model`, { params })
}

/**
 * 获取 表字段
 */
export function getGeneratorTableColumn(params: any) {
    return request.get(`generator/table_column`, { params })
}

/**
 * 同步校验
 */
export function generatorCheckFile(params: Record<string, any>) {
    return request.get(`generator/check_file`, { params })
}

/**
 * 根据模型获取表字段
 */
export function getGeneratorModelTableColumn(params: any) {
    return request.get(`generator/model_table_column`, { params })
}
