export interface SendEmailParam {
    to: string,
    type: number
}

export interface Upload {
    original: string;
    ext: string;
    size: number;
    domain: string;
    url: string;
    path: string;
}