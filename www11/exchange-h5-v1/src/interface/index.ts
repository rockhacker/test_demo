export interface Res<T = any> {
    data: T;
    code: number;
    msg: string | null;
}

export interface Page<T = any> {
    data: T,
    current_page: number;
    last_page: number;
    total: number;
    from: number;
}

export interface Picker {
    text: string,
    value: number
}

export type MatchType = 'micro' | 'lever' | 'trade'

export * from './market'