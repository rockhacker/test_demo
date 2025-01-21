import { floor, multiply } from "lodash-es";

export const getAmount = (number: number | string, price: number | string) => floor(multiply(+number, +price), 2)