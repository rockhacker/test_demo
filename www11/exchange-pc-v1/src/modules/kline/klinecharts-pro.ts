import { Chart, DeepPartial, KLineData, OverlayCreate, Styles } from 'klinecharts';

export interface SymbolInfo {
	ticker: string;
	name?: string;
	shortName?: string;
	exchange?: string;
	market?: string;
	pricePrecision?: number;
	volumePrecision?: number;
	priceCurrency?: string;
	type?: string;
	logo?: string;
}
export interface Period {
	multiplier: number;
	timespan: string;
	text: string;
}
export type DatafeedSubscribeCallback = (data: KLineData) => void;
export interface Datafeed {
	searchSymbols(search?: string): Promise<SymbolInfo[]>;
	getHistoryKLineData(symbol: SymbolInfo, period: Period, from: number, to: number): Promise<KLineData[]>;
	subscribe(symbol: SymbolInfo, period: Period, callback: DatafeedSubscribeCallback): void;
	unsubscribe(symbol: SymbolInfo, period: Period): void;
}
export interface ChartProOptions {
	header: string | HTMLElement;
	container: string | HTMLElement;
	drawingbar: string | HTMLElement;
	styles?: DeepPartial<Styles>;
	watermark?: string | Node;
	theme?: string;
	locale?: string;
	drawingBarVisible?: boolean;
	symbol: SymbolInfo;
	period: Period;
	periods?: Period[];
	timezone?: string;
	mainIndicators?: string[];
	subIndicators?: string[];
	datafeed: Datafeed;
}
export interface ChartPro {
	setTheme(theme: string): void;
	getTheme(): string;
	setStyles(styles: DeepPartial<Styles>): void;
	getStyles(): Styles;
	setLocale(locale: string): void;
	getLocale(): string;
	setTimezone(timezone: string): void;
	getTimezone(): string;
	setSymbol(symbol: SymbolInfo): void;
	getSymbol(): SymbolInfo;
	setPeriod(period: Period): void;
	getPeriod(): Period;
	scrollByDistance(distance: number): void;
	resize(): void;
	getWidget(): Chart;
}
export declare class DefaultDatafeed implements Datafeed {
	constructor(apiKey: string);
	private _apiKey;
	private _prevSymbolMarket?;
	private _ws?;
	searchSymbols(search?: string): Promise<SymbolInfo[]>;
	getHistoryKLineData(symbol: SymbolInfo, period: Period, from: number, to: number): Promise<KLineData[]>;
	subscribe(symbol: SymbolInfo, period: Period, callback: DatafeedSubscribeCallback): void;
	unsubscribe(symbol: SymbolInfo, period: Period): void;
}
export declare class KLineChartPro implements ChartPro {
	constructor(options: ChartProOptions);
	private _container;
	private _chartApi;
	setTheme(theme: string): void;
	getTheme(): string;
	setStyles(styles: DeepPartial<Styles>): void;
	getStyles(): Styles;
	setLocale(locale: string): void;
	getLocale(): string;
	setTimezone(timezone: string): void;
	getTimezone(): string;
	setSymbol(symbol: SymbolInfo): void;
	getSymbol(): SymbolInfo;
	setPeriod(period: Period): void;
	getPeriod(): Period;
	scrollByDistance(distance: number): void;
	resize(): void;
	getWidget(): Chart;
}
export declare class DrawingBarPro {
	constructor(options: any);
	private _container;
}
declare function load(key: string, ls: any): void;
export interface DrawingBarProps {
	locale: string;
	onDrawingItemClick: (overlay: OverlayCreate) => void;
	onModeChange: (mode: string) => void;
	onLockChange: (lock: boolean) => void;
	onVisibleChange: (visible: boolean) => void;
	onRemoveClick: (groupId: string) => void;
}

export {
	load as loadLocales,
};

export as namespace klinechartspro;

export {};
