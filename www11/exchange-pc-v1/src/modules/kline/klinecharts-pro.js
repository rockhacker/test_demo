var _n = Object.defineProperty;
var dn = (e, t, n) => t in e ? _n(e, t, { enumerable: !0, configurable: !0, writable: !0, value: n }) : e[t] = n;
var Se = (e, t, n) => (dn(e, typeof t != "symbol" ? t + "" : t, n), n);
import { utils as x, init as un, FormatDateType as je, DomPosition as O1, ActionType as $n, dispose as gn, TooltipIconPosition as Fe, registerOverlay as hn } from "klinecharts";
function Ie(e, t, n) {
  const o = (e.x - t.x) * Math.cos(n) - (e.y - t.y) * Math.sin(n) + t.x, a = (e.x - t.x) * Math.sin(n) + (e.y - t.y) * Math.cos(n) + t.y;
  return { x: o, y: a };
}
function g1(e, t) {
  if (e.length > 1) {
    let n;
    return e[0].x === e[1].x && e[0].y !== e[1].y ? e[0].y < e[1].y ? n = {
      x: e[0].x,
      y: t.height
    } : n = {
      x: e[0].x,
      y: 0
    } : e[0].x > e[1].x ? n = {
      x: 0,
      y: x.getLinearYFromCoordinates(e[0], e[1], { x: 0, y: e[0].y })
    } : n = {
      x: t.width,
      y: x.getLinearYFromCoordinates(e[0], e[1], { x: t.width, y: e[0].y })
    }, { coordinates: [e[0], n] };
  }
  return [];
}
function wt(e, t) {
  const n = Math.abs(e.x - t.x), o = Math.abs(e.y - t.y);
  return Math.sqrt(n * n + o * o);
}
const mn = {
  name: "arrow",
  totalStep: 3,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  createPointFigures: ({ coordinates: e }) => {
    if (e.length > 1) {
      const t = e[1].x > e[0].x ? 0 : 1, n = x.getLinearSlopeIntercept(e[0], e[1]);
      let o;
      n ? o = Math.atan(n[0]) + Math.PI * t : e[1].y > e[0].y ? o = Math.PI / 2 : o = Math.PI / 2 * 3;
      const a = Ie({ x: e[1].x - 8, y: e[1].y + 4 }, e[1], o), s = Ie({ x: e[1].x - 8, y: e[1].y - 4 }, e[1], o);
      return [
        {
          type: "line",
          attrs: { coordinates: e }
        },
        {
          type: "line",
          ignoreEvent: !0,
          attrs: { coordinates: [a, e[1], s] }
        }
      ];
    }
    return [];
  }
}, pn = {
  name: "circle",
  totalStep: 3,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  styles: {
    circle: {
      color: "rgba(22, 119, 255, 0.15)"
    }
  },
  createPointFigures: ({ coordinates: e }) => {
    if (e.length > 1) {
      const t = wt(e[0], e[1]);
      return {
        type: "circle",
        attrs: {
          ...e[0],
          r: t
        },
        styles: { style: "stroke_fill" }
      };
    }
    return [];
  }
}, fn = {
  name: "rect",
  totalStep: 3,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  styles: {
    polygon: {
      color: "rgba(22, 119, 255, 0.15)"
    }
  },
  createPointFigures: ({ coordinates: e }) => e.length > 1 ? [
    {
      type: "polygon",
      attrs: {
        coordinates: [
          e[0],
          { x: e[1].x, y: e[0].y },
          e[1],
          { x: e[0].x, y: e[1].y }
        ]
      },
      styles: { style: "stroke_fill" }
    }
  ] : []
}, yn = {
  name: "parallelogram",
  totalStep: 4,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  styles: {
    polygon: {
      color: "rgba(22, 119, 255, 0.15)"
    }
  },
  createPointFigures: ({ coordinates: e }) => {
    if (e.length === 2)
      return [
        {
          type: "line",
          ignoreEvent: !0,
          attrs: { coordinates: e }
        }
      ];
    if (e.length === 3) {
      const t = { x: e[0].x + (e[2].x - e[1].x), y: e[2].y };
      return [
        {
          type: "polygon",
          attrs: { coordinates: [e[0], e[1], e[2], t] },
          styles: { style: "stroke_fill" }
        }
      ];
    }
    return [];
  },
  performEventPressedMove: ({ points: e, performPointIndex: t, performPoint: n }) => {
    t < 2 && (e[0].price = n.price, e[1].price = n.price);
  },
  performEventMoveForDrawing: ({ currentStep: e, points: t, performPoint: n }) => {
    e === 2 && (t[0].price = n.price);
  }
}, Cn = {
  name: "triangle",
  totalStep: 4,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  styles: {
    polygon: {
      color: "rgba(22, 119, 255, 0.15)"
    }
  },
  createPointFigures: ({ coordinates: e }) => [
    {
      type: "polygon",
      attrs: { coordinates: e },
      styles: { style: "stroke_fill" }
    }
  ]
}, bn = {
  name: "fibonacciCircle",
  totalStep: 3,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  createPointFigures: ({ coordinates: e }) => {
    if (e.length > 1) {
      const t = Math.abs(e[0].x - e[1].x), n = Math.abs(e[0].y - e[1].y), o = Math.sqrt(t * t + n * n), a = [0.236, 0.382, 0.5, 0.618, 0.786, 1], s = [], r = [];
      return a.forEach((i) => {
        const c = o * i;
        s.push(
          { ...e[0], r: c }
        ), r.push({
          x: e[0].x,
          y: e[0].y + c + 6,
          text: `${(i * 100).toFixed(1)}%`
        });
      }), [
        {
          type: "circle",
          attrs: s,
          styles: { style: "stroke" }
        },
        {
          type: "text",
          ignoreEvent: !0,
          attrs: r
        }
      ];
    }
    return [];
  }
}, vn = {
  name: "fibonacciSegment",
  totalStep: 3,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  createPointFigures: ({ coordinates: e, overlay: t, precision: n }) => {
    const o = [], a = [];
    if (e.length > 1) {
      const s = e[1].x > e[0].x ? e[0].x : e[1].x, r = [1, 0.786, 0.618, 0.5, 0.382, 0.236, 0], i = e[0].y - e[1].y, c = t.points, $ = c[0].value - c[1].value;
      r.forEach((l) => {
        const h = e[1].y + i * l, f = (c[1].value + $ * l).toFixed(n.price);
        o.push({ coordinates: [{ x: e[0].x, y: h }, { x: e[1].x, y: h }] }), a.push({
          x: s,
          y: h,
          text: `${f} (${(l * 100).toFixed(1)}%)`,
          baseline: "bottom"
        });
      });
    }
    return [
      {
        type: "line",
        attrs: o
      },
      {
        type: "text",
        ignoreEvent: !0,
        attrs: a
      }
    ];
  }
}, Ln = {
  name: "fibonacciSpiral",
  totalStep: 3,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  createPointFigures: ({ coordinates: e, bounding: t }) => {
    if (e.length > 1) {
      const n = wt(e[0], e[1]) / Math.sqrt(24), o = e[1].x > e[0].x ? 0 : 1, a = x.getLinearSlopeIntercept(e[0], e[1]);
      let s;
      a ? s = Math.atan(a[0]) + Math.PI * o : e[1].y > e[0].y ? s = Math.PI / 2 : s = Math.PI / 2 * 3;
      const r = Ie(
        { x: e[0].x - n, y: e[0].y },
        e[0],
        s
      ), i = Ie(
        { x: e[0].x - n, y: e[0].y - n },
        e[0],
        s
      ), c = [{
        ...r,
        r: n,
        startAngle: s,
        endAngle: s + Math.PI / 2
      }, {
        ...i,
        r: n * 2,
        startAngle: s + Math.PI / 2,
        endAngle: s + Math.PI
      }];
      let $ = e[0].x - n, l = e[0].y - n;
      for (let h = 2; h < 9; h++) {
        const f = c[h - 2].r + c[h - 1].r;
        let v = 0;
        switch (h % 4) {
          case 0: {
            v = s, $ -= c[h - 2].r;
            break;
          }
          case 1: {
            v = s + Math.PI / 2, l -= c[h - 2].r;
            break;
          }
          case 2: {
            v = s + Math.PI, $ += c[h - 2].r;
            break;
          }
          case 3: {
            v = s + Math.PI / 2 * 3, l += c[h - 2].r;
            break;
          }
        }
        const D = v + Math.PI / 2, z = Ie({ x: $, y: l }, e[0], s);
        c.push({
          ...z,
          r: f,
          startAngle: v,
          endAngle: D
        });
      }
      return [
        {
          type: "arc",
          attrs: c
        },
        {
          type: "line",
          attrs: g1(e, t)
        }
      ];
    }
    return [];
  }
}, xn = {
  name: "fibonacciSpeedResistanceFan",
  totalStep: 3,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  createPointFigures: ({ coordinates: e, bounding: t }) => {
    const n = [];
    let o = [];
    const a = [];
    if (e.length > 1) {
      const s = e[1].x > e[0].x ? -38 : 4, r = e[1].y > e[0].y ? -2 : 20, i = e[1].x - e[0].x, c = e[1].y - e[0].y;
      [1, 0.75, 0.618, 0.5, 0.382, 0.25, 0].forEach((l) => {
        const h = e[1].x - i * l, f = e[1].y - c * l;
        n.push({ coordinates: [{ x: h, y: e[0].y }, { x: h, y: e[1].y }] }), n.push({ coordinates: [{ x: e[0].x, y: f }, { x: e[1].x, y: f }] }), o = o.concat(g1([e[0], { x: h, y: e[1].y }], t)), o = o.concat(g1([e[0], { x: e[1].x, y: f }], t)), a.unshift({
          x: e[0].x + s,
          y: f + 10,
          text: `${l.toFixed(3)}`
        }), a.unshift({
          x: h - 18,
          y: e[0].y + r,
          text: `${l.toFixed(3)}`
        });
      });
    }
    return [
      {
        type: "line",
        attrs: n
      },
      {
        type: "line",
        attrs: o
      },
      {
        type: "text",
        ignoreEvent: !0,
        attrs: a
      }
    ];
  }
}, wn = {
  name: "fibonacciExtension",
  totalStep: 4,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  createPointFigures: ({ coordinates: e, overlay: t, precision: n }) => {
    const o = [], a = [];
    if (e.length > 2) {
      const s = t.points, r = s[1].value - s[0].value, i = e[1].y - e[0].y, c = [0, 0.236, 0.382, 0.5, 0.618, 0.786, 1], $ = e[2].x > e[1].x ? e[1].x : e[2].x;
      c.forEach((l) => {
        const h = e[2].y + i * l, f = (s[2].value + r * l).toFixed(n.price);
        o.push({ coordinates: [{ x: e[1].x, y: h }, { x: e[2].x, y: h }] }), a.push({
          x: $,
          y: h,
          text: `${f} (${(l * 100).toFixed(1)}%)`,
          baseline: "bottom"
        });
      });
    }
    return [
      {
        type: "line",
        attrs: { coordinates: e },
        styles: { style: "dashed" }
      },
      {
        type: "line",
        attrs: o
      },
      {
        type: "text",
        ignoreEvent: !0,
        attrs: a
      }
    ];
  }
}, kn = {
  name: "gannBox",
  totalStep: 3,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  styles: {
    polygon: {
      color: "rgba(22, 119, 255, 0.15)"
    }
  },
  createPointFigures: ({ coordinates: e }) => {
    if (e.length > 1) {
      const t = (e[1].y - e[0].y) / 4, n = e[1].x - e[0].x, o = [
        { coordinates: [e[0], { x: e[1].x, y: e[1].y - t }] },
        { coordinates: [e[0], { x: e[1].x, y: e[1].y - t * 2 }] },
        { coordinates: [{ x: e[0].x, y: e[1].y }, { x: e[1].x, y: e[0].y + t }] },
        { coordinates: [{ x: e[0].x, y: e[1].y }, { x: e[1].x, y: e[0].y + t * 2 }] },
        { coordinates: [{ ...e[0] }, { x: e[0].x + n * 0.236, y: e[1].y }] },
        { coordinates: [{ ...e[0] }, { x: e[0].x + n * 0.5, y: e[1].y }] },
        { coordinates: [{ x: e[0].x, y: e[1].y }, { x: e[0].x + n * 0.236, y: e[0].y }] },
        { coordinates: [{ x: e[0].x, y: e[1].y }, { x: e[0].x + n * 0.5, y: e[0].y }] }
      ], a = [
        { coordinates: [e[0], e[1]] },
        { coordinates: [{ x: e[0].x, y: e[1].y }, { x: e[1].x, y: e[0].y }] }
      ];
      return [
        {
          type: "line",
          attrs: [
            { coordinates: [e[0], { x: e[1].x, y: e[0].y }] },
            { coordinates: [{ x: e[1].x, y: e[0].y }, e[1]] },
            { coordinates: [e[1], { x: e[0].x, y: e[1].y }] },
            { coordinates: [{ x: e[0].x, y: e[1].y }, e[0]] }
          ]
        },
        {
          type: "polygon",
          ignoreEvent: !0,
          attrs: {
            coordinates: [
              e[0],
              { x: e[1].x, y: e[0].y },
              e[1],
              { x: e[0].x, y: e[1].y }
            ]
          },
          styles: { style: "fill" }
        },
        {
          type: "line",
          attrs: o,
          styles: { style: "dashed" }
        },
        {
          type: "line",
          attrs: a
        }
      ];
    }
    return [];
  }
}, An = {
  name: "threeWaves",
  totalStep: 5,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  createPointFigures: ({ coordinates: e }) => {
    const t = e.map((n, o) => ({
      ...n,
      text: `(${o})`,
      baseline: "bottom"
    }));
    return [
      {
        type: "line",
        attrs: { coordinates: e }
      },
      {
        type: "text",
        ignoreEvent: !0,
        attrs: t
      }
    ];
  }
}, Tn = {
  name: "fiveWaves",
  totalStep: 7,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  createPointFigures: ({ coordinates: e }) => {
    const t = e.map((n, o) => ({
      ...n,
      text: `(${o})`,
      baseline: "bottom"
    }));
    return [
      {
        type: "line",
        attrs: { coordinates: e }
      },
      {
        type: "text",
        ignoreEvent: !0,
        attrs: t
      }
    ];
  }
}, Mn = {
  name: "eightWaves",
  totalStep: 10,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  createPointFigures: ({ coordinates: e }) => {
    const t = e.map((n, o) => ({
      ...n,
      text: `(${o})`,
      baseline: "bottom"
    }));
    return [
      {
        type: "line",
        attrs: { coordinates: e }
      },
      {
        type: "text",
        ignoreEvent: !0,
        attrs: t
      }
    ];
  }
}, Sn = {
  name: "anyWaves",
  totalStep: Number.MAX_SAFE_INTEGER,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  createPointFigures: ({ coordinates: e }) => {
    const t = e.map((n, o) => ({
      ...n,
      text: `(${o})`,
      baseline: "bottom"
    }));
    return [
      {
        type: "line",
        attrs: { coordinates: e }
      },
      {
        type: "text",
        ignoreEvent: !0,
        attrs: t
      }
    ];
  }
}, Dn = {
  name: "abcd",
  totalStep: 5,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  createPointFigures: ({ coordinates: e }) => {
    let t = [], n = [];
    const o = ["A", "B", "C", "D"], a = e.map((s, r) => ({
      ...s,
      baseline: "bottom",
      text: `(${o[r]})`
    }));
    return e.length > 2 && (t = [e[0], e[2]], e.length > 3 && (n = [e[1], e[3]])), [
      {
        type: "line",
        attrs: { coordinates: e }
      },
      {
        type: "line",
        attrs: [{ coordinates: t }, { coordinates: n }],
        styles: { style: "dashed" }
      },
      {
        type: "text",
        ignoreEvent: !0,
        attrs: a
      }
    ];
  }
}, In = {
  name: "xabcd",
  totalStep: 6,
  needDefaultPointFigure: !0,
  needDefaultXAxisFigure: !0,
  needDefaultYAxisFigure: !0,
  styles: {
    polygon: {
      color: "rgba(22, 119, 255, 0.15)"
    }
  },
  createPointFigures: ({ coordinates: e, overlay: t }) => {
    const n = [], o = [], a = ["X", "A", "B", "C", "D"], s = e.map((r, i) => ({
      ...r,
      baseline: "bottom",
      text: `(${a[i]})`
    }));
    return e.length > 2 && (n.push({ coordinates: [e[0], e[2]] }), o.push({ coordinates: [e[0], e[1], e[2]] }), e.length > 3 && (n.push({ coordinates: [e[1], e[3]] }), e.length > 4 && (n.push({ coordinates: [e[2], e[4]] }), o.push({ coordinates: [e[2], e[3], e[4]] })))), [
      {
        type: "line",
        attrs: { coordinates: e }
      },
      {
        type: "line",
        attrs: n,
        styles: { style: "dashed" }
      },
      {
        type: "polygon",
        ignoreEvent: !0,
        attrs: o
      },
      {
        type: "text",
        ignoreEvent: !0,
        attrs: s
      }
    ];
  }
}, Bn = [
  mn,
  pn,
  fn,
  Cn,
  yn,
  bn,
  vn,
  Ln,
  xn,
  wn,
  kn,
  An,
  Tn,
  Mn,
  Sn,
  Dn,
  In
];
class AU {
  constructor(t) {
    Se(this, "_apiKey");
    Se(this, "_prevSymbolMarket");
    Se(this, "_ws");
    this._apiKey = t;
  }
  async searchSymbols(t) {
    return await ((await (await fetch(`https://api.polygon.io/v3/reference/tickers?apiKey=${this._apiKey}&active=true&search=${t ?? ""}`)).json()).results || []).map((a) => ({
      ticker: a.ticker,
      name: a.name,
      shortName: a.ticker,
      market: a.market,
      exchange: a.primary_exchange,
      priceCurrency: a.currency_name,
      type: a.type,
      logo: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAAAXNSR0IArs4c6QAAAARzQklUCAgICHwIZIgAAA66SURBVHic7Z17cFTVGcB/527AiKGgRA0ShGhKoQjFMb4qUMCMPIrWqdbHSEdlHDGgI9V2aq2d1hmKtVbRsSTGEcQRp4pStaZQlNYUwYLiSKU0SCMBDRCmoQSJGGF3T/84d2VZk+w9d899hf3NMBnl3ns+5vtyHt/5HoIehpQIaijDYjiSciRlwCCgBCgG+gNFQCGCAvUScaADaAfagFagBdiFoAlBI0m2UkWTEMgA/lmeIYIWIFdkLQNJMBbBJUjOA8agFOwF7cAmBO8hWUeMtWIWezwayxciZwByGb1pZTyCaUguA0YGLNIWBK8jWUExa8Q1HA5YHi0iYQByGTH2UYnkBmA6cHLQMnXBfqAOwXMMYLW4hkTQAmUj1AYgqzkLuAXBTUgGBi2PFoI9SJYAT4nZbA9anK4IpQHIhUzE4i4k04OWxQiCOpI8IubwZtCiZBIqA5A1TEdyH3Bh0LJ4xAYE80QVdUELkiIUBiCf4FIk85FcELQsviB4B8G94jb+GrwoASKfZBgJHkUyNUg5AkOwkhhzxa1sC06EAJALKUJwL3A30DsIGULEYeBhJPPFHNr9Htx3A5A1TECyGCjze+yQ04Rgpqii3s9BfTMAWUsfksxD8iO/xowkggVY3Cdmccif4XxAPskw4rwCjPBjvB5AAwVc6cfewPJ6AFnNzcTZSF75OowgzkZZzc1eD+SZAUiJkNX8FlgM9PVqnB5MX2CxrOa3Uno3U3vyYVlLPxIshR7iyQueOmLMELM4YPrDxg1A1jKQJKuQjDL97eMawWYsJpu+fjZqAPL3DMFiNVBu8rt5vqSRJJXidnaa+qAxA5CPU0aMvwFDTX0zT6fsIMEkcQdNJj5mxADs3/x68sr3ix0kmWBiJsjZAOyQrDXkp32/aSTG+Fz3BDkZgKylH0neym/4AkJtDMflcjpw7QeQEkGCpXnlB4hkFAmW5uIncO8IquFB8uf8MDDd1oUrXFmO7aJc7HbQPJ4wU8zmad2XtA3AvtjZSN69GzYOUkCF7gWSlgHIWvqQyF/shJgGYlToXCXr7QGSzCOv/DAzwtaRYxzPAHYkT+jCmvN0gmCi08giRwZgx/B9QD6MKyo0IRntJMbQ2RKgAjjzyo8OZbbOspJ1BrB3/ZvJR+9GjcMUMCrbqSD7DJDgUfLKjyK9bd11S7czgHyCS0my2pxMIaHvUCgshl5FUFQKQtWJ4FALHGmHz5rhizY43BaomEawqOwuA6mg25cl840L5DexQiithNMvhNMvglMr4IT+zt5t3QS762H332FXfTQNQumwy1zLLmcAO1HzNU+E8oNTK+AbN8KwGc4V3h3JODS9Av98GPauz/17fiK4vKuE1K4NoJr1RDFLd+BY+PYCOK3CuzH2rof3fg07Q5Pkm40NYjYXdfYXnRqAXMhEBH/zVibDFBbDRQ/AiFv8G3PbUlhTpfYNYUcyqbP6BJ2fAizu8lwgkwwcC9c3+Kt8UMvLtZuhZKy/47qhC51+ZQawy7J85LlApjhjAkx7Te3ogyIZhz9PhebQH5jOzixX09kM4POvUQ6cdTVc/kawygewCmDKy2omCjdf0e0xM4BdjeuTSBRk6jtUTb9BKz+djlZ4eRy0bQ1aks4R7GEAg9Orlx07A6hSbOFXPsCkp8OlfFAb0UnaQTn+IRnIPirT/1dBxgM3+CqQW0beptZ+NyTj0LIW9m6A//0L2puP/l1RKXytHAZ9RzmNYoX63z/9IrU53LbUnXxeo3S8KvWfXy4BdgXOFsJbhFFhFcAPP4E+JXrvJeOw+TH44NFjld4VfUrg3Htg5Cx9QzjUAn8YEVbP4X6KKUlVND26BLQynrArH9TGT1f5h1pg+fnw9o+dKT/1zrq58MeL4UCj3nh9StQsFU5OtnUNpBuAYFog4ugy5Lt6z3/RBq9OVH59N7RuUu93tOq9N3KWu/H8IE3XRw1AFV4OP2dO0Xt+4/2578o/a1YePx36DoXiMbmN6xVpurbAzu8Lvup2dgqL1R+nHGmHLU+YGfujl/RnkUGV2Z8JhpG2zu0ZIEHoPRgA9NPMP21eDYkOc+M3LNJ7/rTzzI1tGlvnygAElwQqjFPc7MZNouvq1TVYP7F1rgxAddrIkw3dvYTOcuU3ts4L7B47Id2tZHBwh97zXvwGNr4AfU539uyhvebHN8cYKREiUrd/sUK49XPnzyfj8FyZ87P/8cfZFhbDg5bCMYkOdSRzilUAFz/knTxRx2K4hYxYaZcdmmFY5ddBxa88ESXySMotu69edNi+XP+d838Jlz4bvtvDoJGUWaimitFhz1p3a/qwGXBdg/qZJ8UgC9VRMzokOuDdX7h7t6hUzQTX2fGDbq57exYlQlbzb6KY83/1uyr2PxeOtKtY/w+fUQkgybgJyaJEg5DV7IaIRAGlc8o58P1/mFvXj7SrOP+df4aP/6J/+xdN9ghZzadEtd7PmVNg6mvquGeSZFzNCB8th8bnwxrYYYKDQlZzGOgVtCSuGXELjK8xbwQpEh3KCLbURi8lLDtHhKwhiYcNCXzhzClw2YveH/N218O796ufPQGB7BkGANB/OEx9Wf30mubV8NYd4Q3/dopAWkh6xta3bSssO1clbZqMAeiM0kq45n3lYfRq6fEDSTzam8Cu6FcOYx/XDx9zw+56eON687EH/nDQAv+7VXrOgUaVq/fyOHXO9/J8f8YE+N6b4Q7+6Jr26DqCdOhXDufcrgpGmCgW0RmHWuCVcfoh5MHSIGQ1a4BxQUviC7FCtSycdRUMmW7eGNq2wkvnR6NegOItIatZBvwgaEl8xypQ03f5tcooTio1892ddbDicjPf8p4XC4BdQUsRCMm4Os6lAj1PrYCzr1bLhG7mUTpDpsM3boIPl5iQ0mt2WQgz3aciz383wvp74NnBsOoH7jOJAC5ZAL092muYRNBkIYjUrsVzknHY/hK8eK77490J/WH0XPOymUbQaJEk4u4sD2l8Hl4YBZ+syv5sJqPmhN9JlGSrRRVN9ERfgCk6WmHlldCyTu+9wmL3NQz8oZ0qmiwhkEAOC95xQKIDVl2tf7wbPNkbecywSQikmqME7yFDnB/Yq0jVBXDK5y0qqMMkh1rgg8fgvJ87fyes2cGgdE6qRIxkHXBnkPJ0i27tnb3rzRsAKLeyjgGE2T2sdG7nBsZYG6gw2dD15Zty6mTy3416z+fiT/AaW+cWgN1/dkugAnXHZ816629RqXeJmTqZSeGNOt6S6jmcXiLm9cDEcYLuJcsQj5qanhji32qnpOk6vUTMikCEcYru9DvMg4p3/cr1zvY6s4WfpOn6qAEUswbYH4Q8jtB1xpRWmp8Fvq6ZVfTpDrPjm2G/rWsgzQDsunHhLYD/8V9UxS8dxj1ubiN2UimMuVvvnX2hdK/UpWoEQmapWMFzvovjlCPt+jV6+g5V0Tp9h+Y2dp8SuMJFUeqPXbiQvSZDx8cawABWI9TuMJS8/xv9jJ3+w1VR6dFz3fnmB09RGUi60cZftIWvfLwqFn2MUMcYgLiGBJIlvgqlQ0crvP0T/fd6Fakr2hv3qJ+Dp3R/TDzlHPjmbXDVuzB9pbsZpGGR99HJukiWpFcKh6g2jJhWp18xtDMOtSglpa58+5QcbSeXC+3N6hYxfCllX2kY0XnPoBpeQ+LRQdoAJ5Wq7OCwetpWXB6+hlKCOlHFV2LVOu8ZlOQRzwXKhc+aVf3eMMbiNywKn/KhS51Gu21c/+Fqlx+WmWD7cnjjujDWGeiybVzXvYMF8zwTxxRtW1Usfi7xe6b48JmwKr9bXXbfO7iGDUguMC+RYawCuGAefOtu/8OwjrSrjOF//s7fcZ0ieEdUdT2Td9893GEP+sBJxlVE7/Mj1J29XzS9qnb7YVU+ZNVh1rRwWcMKJFPNSeQDp5yjHD/l15qvGZDoUEbWsCh8jp5MBCtFVfeNQLIbwJMMI85moLcxwfwilQo2eLJq5uQ2ROuLNnUbuX05/CcyJWMOU8AocSvbunvIUWEIWc184GdGxAqSXkWqzWvxGCgcoJw+J2Y4flI3eAd3qq5i+zZFLeEzxQNidvYl3JkBLKQIwQcQsaqixy9NSEaLOdnD/bvfBNqIObQjmJm7XHl8QTDTifLBoQEAiCrqESxwL1UeXxAsEFXUO33csQHYT98HNGiKlMc/GmwdOUa7Oph9KthIT6srFH0OUkBFtl1/JnozAGAPEN4kkuOXO3WVDy4MAEDM5mkg34ojPDxk60Qb1wUi7WZTf4IQxw0cH9RRxRV2kq82rmYAACGQxJiBYLPbb+TJEcFmYsxwq3zIwQAAxCwOYDEZ8lVGAqARi8liFgdy+UhOBgB2XmGSSmBHrt/K45gdJKlM5fflQs4GACBuZycJJpE3Aj/YQYJJ4nZ2mviYEQMAEHfQRJIJ5JcDL2kkyQRxh7nKbsbLxMtaBpJkFZJRpr99XCPYbK/5RhN3jM0AKcQs9mAxjjDnGUaPOizGmVY+eDADpLD9BA8CLlJ58qTxEFX8NJejXnd43ilEVnMz8Bj5uwNdDgJ3uvXwOcWXVjH2BdIr9PSy9OZooIAr3fj2dTG+B+gMcSvbiFGRjydwgGABMf1bPffD+YysYQKSxeTDyzJpQjBTJ5jDBL7MAOmIKuqRjAYegKOVKo5jDgMPIBntt/IhgBkgHfkkw0jwaOTyDkwhWEmMuX5N952LEALkE1yKZH4k0tBMIHgHwb3iNv4avCghQtYwHcl9hD0r2T0bEMwTVeFxkoXKAFLIhUzE4q5QF6nQQVBHkkfEHN4MWpRMQmkAKexyNbcguAkZsRb3gj12vaWnMsuyhIlQG0AKuYwY+6hEcgMqBO3koGXqgv1AHYLnGMDqzIJMYSQSBpCOXEZvWhmPYBqSy4CRAYu0BcHrSFZQzJr0IoxRIHIGkImsZSAJxiK4BMl5wBjAqz7y7cAmu8HGOmKs9eKGzk8ibwCZ2LeQZVgMR1KOpAwYBJQAxUB/lIEUIr5smBEHOlAKbgNagRZgF4ImBI0k2UoVTV7dygXF/wF+fTz59Jc5ygAAAABJRU5ErkJggg=="
    }));
  }
  async getHistoryKLineData(t, n, o, a) {
    return await ((await (await fetch(`https://api.polygon.io/v2/aggs/ticker/${t.ticker}/range/${n.multiplier}/${n.timespan}/${o}/${a}?apiKey=${this._apiKey}`)).json()).results || []).map((i) => ({
      timestamp: i.t,
      open: i.o,
      high: i.h,
      low: i.l,
      close: i.c,
      volume: i.v,
      turnover: i.vw
    }));
  }
  subscribe(t, n, o) {
    var a, s;
    this._prevSymbolMarket !== t.market ? ((a = this._ws) == null || a.close(), this._ws = new WebSocket(`wss://delayed.polygon.io/${t.market}`), this._ws.onopen = () => {
      var r;
      (r = this._ws) == null || r.send(JSON.stringify({ action: "auth", params: this._apiKey }));
    }, this._ws.onmessage = (r) => {
      var c;
      const i = JSON.parse(r.data);
      i[0].ev === "status" ? i[0].status === "auth_success" && ((c = this._ws) == null || c.send(JSON.stringify({ action: "subscribe", params: `T.${t.ticker}` }))) : "sym" in i && o({
        timestamp: i.s,
        open: i.o,
        high: i.h,
        low: i.l,
        close: i.c,
        volume: i.v,
        turnover: i.vw
      });
    }) : (s = this._ws) == null || s.send(JSON.stringify({ action: "subscribe", params: `T.${t.ticker}` })), this._prevSymbolMarket = t.market;
  }
  unsubscribe(t, n) {
  }
}
const Q = {};
function Un(e) {
  Q.context = e;
}
const Pn = (e, t) => e === t, h1 = Symbol("solid-proxy"), zn = Symbol("solid-track"), Ye = {
  equals: Pn
};
let kt = Dt;
const ee = 1, Ge = 2, At = {
  owned: null,
  cleanups: null,
  context: null,
  owner: null
};
var B = null;
let se = null, A = null, N = null, X = null, x1 = 0;
function Ze(e, t) {
  const n = A, o = B, a = e.length === 0, s = a ? At : {
    owned: null,
    cleanups: null,
    context: null,
    owner: t === void 0 ? o : t
  }, r = a ? e : () => e(() => ie(() => t1(s)));
  B = s, A = null;
  try {
    return pe(r, !0);
  } finally {
    A = n, B = o;
  }
}
function C(e, t) {
  t = t ? Object.assign({}, Ye, t) : Ye;
  const n = {
    value: e,
    observers: null,
    observerSlots: null,
    comparator: t.equals || void 0
  }, o = (a) => (typeof a == "function" && (a = a(n.value)), St(n, a));
  return [Mt.bind(n), o];
}
function O(e, t, n) {
  const o = k1(e, t, !1, ee);
  Pe(o);
}
function J(e, t, n) {
  kt = En;
  const o = k1(e, t, !1, ee);
  o.user = !0, X ? X.push(o) : Pe(o);
}
function I(e, t, n) {
  n = n ? Object.assign({}, Ye, n) : Ye;
  const o = k1(e, t, !0, 0);
  return o.observers = null, o.observerSlots = null, o.comparator = n.equals || void 0, Pe(o), Mt.bind(o);
}
function ie(e) {
  if (A === null)
    return e();
  const t = A;
  A = null;
  try {
    return e();
  } finally {
    A = t;
  }
}
function Tt(e) {
  J(() => ie(e));
}
function w1(e) {
  return B === null || (B.cleanups === null ? B.cleanups = [e] : B.cleanups.push(e)), e;
}
function Rn(e) {
  const t = A, n = B;
  return Promise.resolve().then(() => {
    A = t, B = n;
    let o;
    return pe(e, !1), A = B = null, o ? o.done : void 0;
  });
}
function Mt() {
  const e = se;
  if (this.sources && (this.state || e))
    if (this.state === ee || e)
      Pe(this);
    else {
      const t = N;
      N = null, pe(() => Xe(this), !1), N = t;
    }
  if (A) {
    const t = this.observers ? this.observers.length : 0;
    A.sources ? (A.sources.push(this), A.sourceSlots.push(t)) : (A.sources = [this], A.sourceSlots = [t]), this.observers ? (this.observers.push(A), this.observerSlots.push(A.sources.length - 1)) : (this.observers = [A], this.observerSlots = [A.sources.length - 1]);
  }
  return this.value;
}
function St(e, t, n) {
  let o = e.value;
  return (!e.comparator || !e.comparator(o, t)) && (e.value = t, e.observers && e.observers.length && pe(() => {
    for (let a = 0; a < e.observers.length; a += 1) {
      const s = e.observers[a], r = se && se.running;
      r && se.disposed.has(s), (r && !s.tState || !r && !s.state) && (s.pure ? N.push(s) : X.push(s), s.observers && It(s)), r || (s.state = ee);
    }
    if (N.length > 1e6)
      throw N = [], new Error();
  }, !1)), t;
}
function Pe(e) {
  if (!e.fn)
    return;
  t1(e);
  const t = B, n = A, o = x1;
  A = B = e, Nn(e, e.value, o), A = n, B = t;
}
function Nn(e, t, n) {
  let o;
  try {
    o = e.fn(t);
  } catch (a) {
    e.pure && (e.state = ee, e.owned && e.owned.forEach(t1), e.owned = null), Bt(a);
  }
  (!e.updatedAt || e.updatedAt <= n) && (e.updatedAt != null && "observers" in e ? St(e, o) : e.value = o, e.updatedAt = n);
}
function k1(e, t, n, o = ee, a) {
  const s = {
    fn: e,
    state: o,
    updatedAt: null,
    owned: null,
    sources: null,
    sourceSlots: null,
    cleanups: null,
    value: t,
    owner: B,
    context: null,
    pure: n
  };
  return B === null || B !== At && (B.owned ? B.owned.push(s) : B.owned = [s]), s;
}
function Je(e) {
  const t = se;
  if (e.state === 0 || t)
    return;
  if (e.state === Ge || t)
    return Xe(e);
  if (e.suspense && ie(e.suspense.inFallback))
    return e.suspense.effects.push(e);
  const n = [e];
  for (; (e = e.owner) && (!e.updatedAt || e.updatedAt < x1); )
    (e.state || t) && n.push(e);
  for (let o = n.length - 1; o >= 0; o--)
    if (e = n[o], e.state === ee || t)
      Pe(e);
    else if (e.state === Ge || t) {
      const a = N;
      N = null, pe(() => Xe(e, n[0]), !1), N = a;
    }
}
function pe(e, t) {
  if (N)
    return e();
  let n = !1;
  t || (N = []), X ? n = !0 : X = [], x1++;
  try {
    const o = e();
    return On(n), o;
  } catch (o) {
    n || (X = null), N = null, Bt(o);
  }
}
function On(e) {
  if (N && (Dt(N), N = null), e)
    return;
  const t = X;
  X = null, t.length && pe(() => kt(t), !1);
}
function Dt(e) {
  for (let t = 0; t < e.length; t++)
    Je(e[t]);
}
function En(e) {
  let t, n = 0;
  for (t = 0; t < e.length; t++) {
    const o = e[t];
    o.user ? e[n++] = o : Je(o);
  }
  for (Q.context && Un(), t = 0; t < n; t++)
    Je(e[t]);
}
function Xe(e, t) {
  const n = se;
  e.state = 0;
  for (let o = 0; o < e.sources.length; o += 1) {
    const a = e.sources[o];
    a.sources && (a.state === ee || n ? a !== t && Je(a) : (a.state === Ge || n) && Xe(a, t));
  }
}
function It(e) {
  const t = se;
  for (let n = 0; n < e.observers.length; n += 1) {
    const o = e.observers[n];
    (!o.state || t) && (o.state = Ge, o.pure ? N.push(o) : X.push(o), o.observers && It(o));
  }
}
function t1(e) {
  let t;
  if (e.sources)
    for (; e.sources.length; ) {
      const n = e.sources.pop(), o = e.sourceSlots.pop(), a = n.observers;
      if (a && a.length) {
        const s = a.pop(), r = n.observerSlots.pop();
        o < a.length && (s.sourceSlots[r] = o, a[o] = s, n.observerSlots[o] = r);
      }
    }
  if (e.owned) {
    for (t = 0; t < e.owned.length; t++)
      t1(e.owned[t]);
    e.owned = null;
  }
  if (e.cleanups) {
    for (t = 0; t < e.cleanups.length; t++)
      e.cleanups[t]();
    e.cleanups = null;
  }
  e.state = 0, e.context = null;
}
function jn(e) {
  return e instanceof Error || typeof e == "string" ? e : new Error("Unknown error");
}
function Bt(e) {
  throw e = jn(e), e;
}
const Fn = Symbol("fallback");
function E1(e) {
  for (let t = 0; t < e.length; t++)
    e[t]();
}
function Kn(e, t, n = {}) {
  let o = [], a = [], s = [], r = 0, i = t.length > 1 ? [] : null;
  return w1(() => E1(s)), () => {
    let c = e() || [], $, l;
    return c[zn], ie(() => {
      let f = c.length, v, D, z, U, M, E, S, T, V;
      if (f === 0)
        r !== 0 && (E1(s), s = [], o = [], a = [], r = 0, i && (i = [])), n.fallback && (o = [Fn], a[0] = Ze((le) => (s[0] = le, n.fallback())), r = 1);
      else if (r === 0) {
        for (a = new Array(f), l = 0; l < f; l++)
          o[l] = c[l], a[l] = Ze(h);
        r = f;
      } else {
        for (z = new Array(f), U = new Array(f), i && (M = new Array(f)), E = 0, S = Math.min(r, f); E < S && o[E] === c[E]; E++)
          ;
        for (S = r - 1, T = f - 1; S >= E && T >= E && o[S] === c[T]; S--, T--)
          z[T] = a[S], U[T] = s[S], i && (M[T] = i[S]);
        for (v = /* @__PURE__ */ new Map(), D = new Array(T + 1), l = T; l >= E; l--)
          V = c[l], $ = v.get(V), D[l] = $ === void 0 ? -1 : $, v.set(V, l);
        for ($ = E; $ <= S; $++)
          V = o[$], l = v.get(V), l !== void 0 && l !== -1 ? (z[l] = a[$], U[l] = s[$], i && (M[l] = i[$]), l = D[l], v.set(V, l)) : s[$]();
        for (l = E; l < f; l++)
          l in z ? (a[l] = z[l], s[l] = U[l], i && (i[l] = M[l], i[l](l))) : a[l] = Ze(h);
        a = a.slice(0, r = f), o = c.slice(0);
      }
      return a;
    });
    function h(f) {
      if (s[l] = f, i) {
        const [v, D] = C(l);
        return i[l] = D, t(c[l], v);
      }
      return t(c[l]);
    }
  };
}
function m(e, t) {
  return ie(() => e(t || {}));
}
function Ke() {
  return !0;
}
const Vn = {
  get(e, t, n) {
    return t === h1 ? n : e.get(t);
  },
  has(e, t) {
    return t === h1 ? !0 : e.has(t);
  },
  set: Ke,
  deleteProperty: Ke,
  getOwnPropertyDescriptor(e, t) {
    return {
      configurable: !0,
      enumerable: !0,
      get() {
        return e.get(t);
      },
      set: Ke,
      deleteProperty: Ke
    };
  },
  ownKeys(e) {
    return e.keys();
  }
};
function u1(e) {
  return (e = typeof e == "function" ? e() : e) ? e : {};
}
function Ut(...e) {
  let t = !1;
  for (let o = 0; o < e.length; o++) {
    const a = e[o];
    t = t || !!a && h1 in a, e[o] = typeof a == "function" ? (t = !0, I(a)) : a;
  }
  if (t)
    return new Proxy({
      get(o) {
        for (let a = e.length - 1; a >= 0; a--) {
          const s = u1(e[a])[o];
          if (s !== void 0)
            return s;
        }
      },
      has(o) {
        for (let a = e.length - 1; a >= 0; a--)
          if (o in u1(e[a]))
            return !0;
        return !1;
      },
      keys() {
        const o = [];
        for (let a = 0; a < e.length; a++)
          o.push(...Object.keys(u1(e[a])));
        return [...new Set(o)];
      }
    }, Vn);
  const n = {};
  for (let o = e.length - 1; o >= 0; o--)
    if (e[o]) {
      const a = Object.getOwnPropertyDescriptors(e[o]);
      for (const s in a)
        s in n || Object.defineProperty(n, s, {
          enumerable: !0,
          get() {
            for (let r = e.length - 1; r >= 0; r--) {
              const i = (e[r] || {})[s];
              if (i !== void 0)
                return i;
            }
          }
        });
    }
  return n;
}
function Qn(e) {
  const t = "fallback" in e && {
    fallback: () => e.fallback
  };
  return I(Kn(() => e.each, e.children, t || void 0));
}
function j(e) {
  let t = !1;
  const n = e.keyed, o = I(() => e.when, void 0, {
    equals: (a, s) => t ? a === s : !a == !s
  });
  return I(() => {
    const a = o();
    if (a) {
      const s = e.children, r = typeof s == "function" && s.length > 0;
      return t = n || r, r ? ie(() => s(a)) : s;
    }
    return e.fallback;
  }, void 0, void 0);
}
function Zn(e, t, n) {
  let o = n.length, a = t.length, s = o, r = 0, i = 0, c = t[a - 1].nextSibling, $ = null;
  for (; r < a || i < s; ) {
    if (t[r] === n[i]) {
      r++, i++;
      continue;
    }
    for (; t[a - 1] === n[s - 1]; )
      a--, s--;
    if (a === r) {
      const l = s < o ? i ? n[i - 1].nextSibling : n[s - i] : c;
      for (; i < s; )
        e.insertBefore(n[i++], l);
    } else if (s === i)
      for (; r < a; )
        (!$ || !$.has(t[r])) && t[r].remove(), r++;
    else if (t[r] === n[s - 1] && n[i] === t[a - 1]) {
      const l = t[--a].nextSibling;
      e.insertBefore(n[i++], t[r++].nextSibling), e.insertBefore(n[--s], l), t[a] = n[s];
    } else {
      if (!$) {
        $ = /* @__PURE__ */ new Map();
        let h = i;
        for (; h < s; )
          $.set(n[h], h++);
      }
      const l = $.get(t[r]);
      if (l != null)
        if (i < l && l < s) {
          let h = r, f = 1, v;
          for (; ++h < a && h < s && !((v = $.get(t[h])) == null || v !== l + f); )
            f++;
          if (f > l - i) {
            const D = t[r];
            for (; i < l; )
              e.insertBefore(n[i++], D);
          } else
            e.replaceChild(n[i++], t[r++]);
        } else
          r++;
      else
        t[r++].remove();
    }
  }
}
const j1 = "_$DX_DELEGATE";
function We(e, t, n, o = {}) {
  let a;
  return Ze((s) => {
    a = s, t === document ? e() : p(t, e(), t.firstChild ? null : void 0, n);
  }, o.owner), () => {
    a(), t.textContent = "";
  };
}
function g(e, t, n) {
  const o = document.createElement("template");
  o.innerHTML = e;
  let a = o.content.firstChild;
  return n && (a = a.firstChild), a;
}
function Z(e, t = window.document) {
  const n = t[j1] || (t[j1] = /* @__PURE__ */ new Set());
  for (let o = 0, a = e.length; o < a; o++) {
    const s = e[o];
    n.has(s) || (n.add(s), t.addEventListener(s, Hn));
  }
}
function W(e, t, n) {
  n == null ? e.removeAttribute(t) : e.setAttribute(t, n);
}
function re(e, t) {
  t == null ? e.removeAttribute("class") : e.className = t;
}
function Be(e, t, n, o) {
  if (o)
    Array.isArray(n) ? (e[`$$${t}`] = n[0], e[`$$${t}Data`] = n[1]) : e[`$$${t}`] = n;
  else if (Array.isArray(n)) {
    const a = n[0];
    e.addEventListener(t, n[0] = (s) => a.call(e, n[1], s));
  } else
    e.addEventListener(t, n);
}
function fe(e, t, n) {
  if (!t)
    return n ? W(e, "style") : t;
  const o = e.style;
  if (typeof t == "string")
    return o.cssText = t;
  typeof n == "string" && (o.cssText = n = void 0), n || (n = {}), t || (t = {});
  let a, s;
  for (s in n)
    t[s] == null && o.removeProperty(s), delete n[s];
  for (s in t)
    a = t[s], a !== n[s] && (o.setProperty(s, a), n[s] = a);
  return n;
}
function A1(e, t, n) {
  return ie(() => e(t, n));
}
function p(e, t, n, o) {
  if (n !== void 0 && !o && (o = []), typeof t != "function")
    return qe(e, t, o, n);
  O((a) => qe(e, t(), a, n), o);
}
function Hn(e) {
  const t = `$$${e.type}`;
  let n = e.composedPath && e.composedPath()[0] || e.target;
  for (e.target !== n && Object.defineProperty(e, "target", {
    configurable: !0,
    value: n
  }), Object.defineProperty(e, "currentTarget", {
    configurable: !0,
    get() {
      return n || document;
    }
  }), Q.registry && !Q.done && (Q.done = !0, document.querySelectorAll("[id^=pl-]").forEach((o) => {
    for (; o && o.nodeType !== 8 && o.nodeValue !== "pl-" + e; ) {
      let a = o.nextSibling;
      o.remove(), o = a;
    }
    o && o.remove();
  })); n; ) {
    const o = n[t];
    if (o && !n.disabled) {
      const a = n[`${t}Data`];
      if (a !== void 0 ? o.call(n, a, e) : o.call(n, e), e.cancelBubble)
        return;
    }
    n = n._$host || n.parentNode || n.host;
  }
}
function qe(e, t, n, o, a) {
  for (Q.context && !n && (n = [...e.childNodes]); typeof n == "function"; )
    n = n();
  if (t === n)
    return n;
  const s = typeof t, r = o !== void 0;
  if (e = r && n[0] && n[0].parentNode || e, s === "string" || s === "number") {
    if (Q.context)
      return n;
    if (s === "number" && (t = t.toString()), r) {
      let i = n[0];
      i && i.nodeType === 3 ? i.data = t : i = document.createTextNode(t), n = he(e, n, o, i);
    } else
      n !== "" && typeof n == "string" ? n = e.firstChild.data = t : n = e.textContent = t;
  } else if (t == null || s === "boolean") {
    if (Q.context)
      return n;
    n = he(e, n, o);
  } else {
    if (s === "function")
      return O(() => {
        let i = t();
        for (; typeof i == "function"; )
          i = i();
        n = qe(e, i, n, o);
      }), () => n;
    if (Array.isArray(t)) {
      const i = [], c = n && Array.isArray(n);
      if (m1(i, t, n, a))
        return O(() => n = qe(e, i, n, o, !0)), () => n;
      if (Q.context) {
        if (!i.length)
          return n;
        for (let $ = 0; $ < i.length; $++)
          if (i[$].parentNode)
            return n = i;
      }
      if (i.length === 0) {
        if (n = he(e, n, o), r)
          return n;
      } else
        c ? n.length === 0 ? F1(e, i, o) : Zn(e, n, i) : (n && he(e), F1(e, i));
      n = i;
    } else if (t instanceof Node) {
      if (Q.context && t.parentNode)
        return n = r ? [t] : t;
      if (Array.isArray(n)) {
        if (r)
          return n = he(e, n, o, t);
        he(e, n, null, t);
      } else
        n == null || n === "" || !e.firstChild ? e.appendChild(t) : e.replaceChild(t, e.firstChild);
      n = t;
    }
  }
  return n;
}
function m1(e, t, n, o) {
  let a = !1;
  for (let s = 0, r = t.length; s < r; s++) {
    let i = t[s], c = n && n[s];
    if (i instanceof Node)
      e.push(i);
    else if (!(i == null || i === !0 || i === !1))
      if (Array.isArray(i))
        a = m1(e, i, c) || a;
      else if (typeof i == "function")
        if (o) {
          for (; typeof i == "function"; )
            i = i();
          a = m1(e, Array.isArray(i) ? i : [i], Array.isArray(c) ? c : [c]) || a;
        } else
          e.push(i), a = !0;
      else {
        const $ = String(i);
        c && c.nodeType === 3 && c.data === $ ? e.push(c) : e.push(document.createTextNode($));
      }
  }
  return a;
}
function F1(e, t, n = null) {
  for (let o = 0, a = t.length; o < a; o++)
    e.insertBefore(t[o], n);
}
function he(e, t, n, o) {
  if (n === void 0)
    return e.textContent = "";
  const a = o || document.createTextNode("");
  if (t.length) {
    let s = !1;
    for (let r = t.length - 1; r >= 0; r--) {
      const i = t[r];
      if (a !== i) {
        const c = i.parentNode === e;
        !s && !r ? c ? e.replaceChild(a, i) : e.insertBefore(a, n) : c && i.remove();
      } else
        s = !0;
    }
  } else
    e.insertBefore(a, n);
  return [a];
}
var Ve = typeof globalThis < "u" ? globalThis : typeof window < "u" ? window : typeof global < "u" ? global : typeof self < "u" ? self : {}, Yn = typeof Ve == "object" && Ve && Ve.Object === Object && Ve, Pt = Yn, Gn = Pt, Jn = typeof self == "object" && self && self.Object === Object && self, Xn = Gn || Jn || Function("return this")(), H = Xn, Wn = H, qn = Wn.Symbol, n1 = qn, K1 = n1, zt = Object.prototype, e0 = zt.hasOwnProperty, t0 = zt.toString, De = K1 ? K1.toStringTag : void 0;
function n0(e) {
  var t = e0.call(e, De), n = e[De];
  try {
    e[De] = void 0;
    var o = !0;
  } catch {
  }
  var a = t0.call(e);
  return o && (t ? e[De] = n : delete e[De]), a;
}
var o0 = n0, a0 = Object.prototype, s0 = a0.toString;
function i0(e) {
  return s0.call(e);
}
var r0 = i0, V1 = n1, c0 = o0, l0 = r0, _0 = "[object Null]", d0 = "[object Undefined]", Q1 = V1 ? V1.toStringTag : void 0;
function u0(e) {
  return e == null ? e === void 0 ? d0 : _0 : Q1 && Q1 in Object(e) ? c0(e) : l0(e);
}
var ze = u0;
function $0(e) {
  var t = typeof e;
  return e != null && (t == "object" || t == "function");
}
var ye = $0, g0 = ze, h0 = ye, m0 = "[object AsyncFunction]", p0 = "[object Function]", f0 = "[object GeneratorFunction]", y0 = "[object Proxy]";
function C0(e) {
  if (!h0(e))
    return !1;
  var t = g0(e);
  return t == p0 || t == f0 || t == m0 || t == y0;
}
var Rt = C0, b0 = H, v0 = b0["__core-js_shared__"], L0 = v0, $1 = L0, Z1 = function() {
  var e = /[^.]+$/.exec($1 && $1.keys && $1.keys.IE_PROTO || "");
  return e ? "Symbol(src)_1." + e : "";
}();
function x0(e) {
  return !!Z1 && Z1 in e;
}
var w0 = x0, k0 = Function.prototype, A0 = k0.toString;
function T0(e) {
  if (e != null) {
    try {
      return A0.call(e);
    } catch {
    }
    try {
      return e + "";
    } catch {
    }
  }
  return "";
}
var Nt = T0, M0 = Rt, S0 = w0, D0 = ye, I0 = Nt, B0 = /[\\^$.*+?()[\]{}|]/g, U0 = /^\[object .+?Constructor\]$/, P0 = Function.prototype, z0 = Object.prototype, R0 = P0.toString, N0 = z0.hasOwnProperty, O0 = RegExp(
  "^" + R0.call(N0).replace(B0, "\\$&").replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g, "$1.*?") + "$"
);
function E0(e) {
  if (!D0(e) || S0(e))
    return !1;
  var t = M0(e) ? O0 : U0;
  return t.test(I0(e));
}
var j0 = E0;
function F0(e, t) {
  return e == null ? void 0 : e[t];
}
var K0 = F0, V0 = j0, Q0 = K0;
function Z0(e, t) {
  var n = Q0(e, t);
  return V0(n) ? n : void 0;
}
var ce = Z0, H0 = ce, Y0 = function() {
  try {
    var e = H0(Object, "defineProperty");
    return e({}, "", {}), e;
  } catch {
  }
}(), G0 = Y0, H1 = G0;
function J0(e, t, n) {
  t == "__proto__" && H1 ? H1(e, t, {
    configurable: !0,
    enumerable: !0,
    value: n,
    writable: !0
  }) : e[t] = n;
}
var Ot = J0;
function X0(e, t) {
  return e === t || e !== e && t !== t;
}
var Et = X0, W0 = Ot, q0 = Et, eo = Object.prototype, to = eo.hasOwnProperty;
function no(e, t, n) {
  var o = e[t];
  (!(to.call(e, t) && q0(o, n)) || n === void 0 && !(t in e)) && W0(e, t, n);
}
var T1 = no, oo = Array.isArray, Ce = oo;
function ao(e) {
  return e != null && typeof e == "object";
}
var be = ao, so = ze, io = be, ro = "[object Symbol]";
function co(e) {
  return typeof e == "symbol" || io(e) && so(e) == ro;
}
var M1 = co, lo = Ce, _o = M1, uo = /\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/, $o = /^\w*$/;
function go(e, t) {
  if (lo(e))
    return !1;
  var n = typeof e;
  return n == "number" || n == "symbol" || n == "boolean" || e == null || _o(e) ? !0 : $o.test(e) || !uo.test(e) || t != null && e in Object(t);
}
var ho = go, mo = ce, po = mo(Object, "create"), o1 = po, Y1 = o1;
function fo() {
  this.__data__ = Y1 ? Y1(null) : {}, this.size = 0;
}
var yo = fo;
function Co(e) {
  var t = this.has(e) && delete this.__data__[e];
  return this.size -= t ? 1 : 0, t;
}
var bo = Co, vo = o1, Lo = "__lodash_hash_undefined__", xo = Object.prototype, wo = xo.hasOwnProperty;
function ko(e) {
  var t = this.__data__;
  if (vo) {
    var n = t[e];
    return n === Lo ? void 0 : n;
  }
  return wo.call(t, e) ? t[e] : void 0;
}
var Ao = ko, To = o1, Mo = Object.prototype, So = Mo.hasOwnProperty;
function Do(e) {
  var t = this.__data__;
  return To ? t[e] !== void 0 : So.call(t, e);
}
var Io = Do, Bo = o1, Uo = "__lodash_hash_undefined__";
function Po(e, t) {
  var n = this.__data__;
  return this.size += this.has(e) ? 0 : 1, n[e] = Bo && t === void 0 ? Uo : t, this;
}
var zo = Po, Ro = yo, No = bo, Oo = Ao, Eo = Io, jo = zo;
function ve(e) {
  var t = -1, n = e == null ? 0 : e.length;
  for (this.clear(); ++t < n; ) {
    var o = e[t];
    this.set(o[0], o[1]);
  }
}
ve.prototype.clear = Ro;
ve.prototype.delete = No;
ve.prototype.get = Oo;
ve.prototype.has = Eo;
ve.prototype.set = jo;
var Fo = ve;
function Ko() {
  this.__data__ = [], this.size = 0;
}
var Vo = Ko, Qo = Et;
function Zo(e, t) {
  for (var n = e.length; n--; )
    if (Qo(e[n][0], t))
      return n;
  return -1;
}
var a1 = Zo, Ho = a1, Yo = Array.prototype, Go = Yo.splice;
function Jo(e) {
  var t = this.__data__, n = Ho(t, e);
  if (n < 0)
    return !1;
  var o = t.length - 1;
  return n == o ? t.pop() : Go.call(t, n, 1), --this.size, !0;
}
var Xo = Jo, Wo = a1;
function qo(e) {
  var t = this.__data__, n = Wo(t, e);
  return n < 0 ? void 0 : t[n][1];
}
var ea = qo, ta = a1;
function na(e) {
  return ta(this.__data__, e) > -1;
}
var oa = na, aa = a1;
function sa(e, t) {
  var n = this.__data__, o = aa(n, e);
  return o < 0 ? (++this.size, n.push([e, t])) : n[o][1] = t, this;
}
var ia = sa, ra = Vo, ca = Xo, la = ea, _a = oa, da = ia;
function Le(e) {
  var t = -1, n = e == null ? 0 : e.length;
  for (this.clear(); ++t < n; ) {
    var o = e[t];
    this.set(o[0], o[1]);
  }
}
Le.prototype.clear = ra;
Le.prototype.delete = ca;
Le.prototype.get = la;
Le.prototype.has = _a;
Le.prototype.set = da;
var s1 = Le, ua = ce, $a = H, ga = ua($a, "Map"), S1 = ga, G1 = Fo, ha = s1, ma = S1;
function pa() {
  this.size = 0, this.__data__ = {
    hash: new G1(),
    map: new (ma || ha)(),
    string: new G1()
  };
}
var fa = pa;
function ya(e) {
  var t = typeof e;
  return t == "string" || t == "number" || t == "symbol" || t == "boolean" ? e !== "__proto__" : e === null;
}
var Ca = ya, ba = Ca;
function va(e, t) {
  var n = e.__data__;
  return ba(t) ? n[typeof t == "string" ? "string" : "hash"] : n.map;
}
var i1 = va, La = i1;
function xa(e) {
  var t = La(this, e).delete(e);
  return this.size -= t ? 1 : 0, t;
}
var wa = xa, ka = i1;
function Aa(e) {
  return ka(this, e).get(e);
}
var Ta = Aa, Ma = i1;
function Sa(e) {
  return Ma(this, e).has(e);
}
var Da = Sa, Ia = i1;
function Ba(e, t) {
  var n = Ia(this, e), o = n.size;
  return n.set(e, t), this.size += n.size == o ? 0 : 1, this;
}
var Ua = Ba, Pa = fa, za = wa, Ra = Ta, Na = Da, Oa = Ua;
function xe(e) {
  var t = -1, n = e == null ? 0 : e.length;
  for (this.clear(); ++t < n; ) {
    var o = e[t];
    this.set(o[0], o[1]);
  }
}
xe.prototype.clear = Pa;
xe.prototype.delete = za;
xe.prototype.get = Ra;
xe.prototype.has = Na;
xe.prototype.set = Oa;
var jt = xe, Ft = jt, Ea = "Expected a function";
function D1(e, t) {
  if (typeof e != "function" || t != null && typeof t != "function")
    throw new TypeError(Ea);
  var n = function() {
    var o = arguments, a = t ? t.apply(this, o) : o[0], s = n.cache;
    if (s.has(a))
      return s.get(a);
    var r = e.apply(this, o);
    return n.cache = s.set(a, r) || s, r;
  };
  return n.cache = new (D1.Cache || Ft)(), n;
}
D1.Cache = Ft;
var ja = D1, Fa = ja, Ka = 500;
function Va(e) {
  var t = Fa(e, function(o) {
    return n.size === Ka && n.clear(), o;
  }), n = t.cache;
  return t;
}
var Qa = Va, Za = Qa, Ha = /[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g, Ya = /\\(\\)?/g, Ga = Za(function(e) {
  var t = [];
  return e.charCodeAt(0) === 46 && t.push(""), e.replace(Ha, function(n, o, a, s) {
    t.push(a ? s.replace(Ya, "$1") : o || n);
  }), t;
}), Ja = Ga;
function Xa(e, t) {
  for (var n = -1, o = e == null ? 0 : e.length, a = Array(o); ++n < o; )
    a[n] = t(e[n], n, e);
  return a;
}
var Wa = Xa, J1 = n1, qa = Wa, e9 = Ce, t9 = M1, n9 = 1 / 0, X1 = J1 ? J1.prototype : void 0, W1 = X1 ? X1.toString : void 0;
function Kt(e) {
  if (typeof e == "string")
    return e;
  if (e9(e))
    return qa(e, Kt) + "";
  if (t9(e))
    return W1 ? W1.call(e) : "";
  var t = e + "";
  return t == "0" && 1 / e == -n9 ? "-0" : t;
}
var o9 = Kt, a9 = o9;
function s9(e) {
  return e == null ? "" : a9(e);
}
var i9 = s9, r9 = Ce, c9 = ho, l9 = Ja, _9 = i9;
function d9(e, t) {
  return r9(e) ? e : c9(e, t) ? [e] : l9(_9(e));
}
var u9 = d9, $9 = 9007199254740991, g9 = /^(?:0|[1-9]\d*)$/;
function h9(e, t) {
  var n = typeof e;
  return t = t ?? $9, !!t && (n == "number" || n != "symbol" && g9.test(e)) && e > -1 && e % 1 == 0 && e < t;
}
var Vt = h9, m9 = M1, p9 = 1 / 0;
function f9(e) {
  if (typeof e == "string" || m9(e))
    return e;
  var t = e + "";
  return t == "0" && 1 / e == -p9 ? "-0" : t;
}
var y9 = f9, C9 = T1, b9 = u9, v9 = Vt, q1 = ye, L9 = y9;
function x9(e, t, n, o) {
  if (!q1(e))
    return e;
  t = b9(t, e);
  for (var a = -1, s = t.length, r = s - 1, i = e; i != null && ++a < s; ) {
    var c = L9(t[a]), $ = n;
    if (c === "__proto__" || c === "constructor" || c === "prototype")
      return e;
    if (a != r) {
      var l = i[c];
      $ = o ? o(l, c, i) : void 0, $ === void 0 && ($ = q1(l) ? l : v9(t[a + 1]) ? [] : {});
    }
    C9(i, c, $), i = i[c];
  }
  return e;
}
var w9 = x9, k9 = w9;
function A9(e, t, n) {
  return e == null ? e : k9(e, t, n);
}
var p1 = A9, T9 = s1;
function M9() {
  this.__data__ = new T9(), this.size = 0;
}
var S9 = M9;
function D9(e) {
  var t = this.__data__, n = t.delete(e);
  return this.size = t.size, n;
}
var I9 = D9;
function B9(e) {
  return this.__data__.get(e);
}
var U9 = B9;
function P9(e) {
  return this.__data__.has(e);
}
var z9 = P9, R9 = s1, N9 = S1, O9 = jt, E9 = 200;
function j9(e, t) {
  var n = this.__data__;
  if (n instanceof R9) {
    var o = n.__data__;
    if (!N9 || o.length < E9 - 1)
      return o.push([e, t]), this.size = ++n.size, this;
    n = this.__data__ = new O9(o);
  }
  return n.set(e, t), this.size = n.size, this;
}
var F9 = j9, K9 = s1, V9 = S9, Q9 = I9, Z9 = U9, H9 = z9, Y9 = F9;
function we(e) {
  var t = this.__data__ = new K9(e);
  this.size = t.size;
}
we.prototype.clear = V9;
we.prototype.delete = Q9;
we.prototype.get = Z9;
we.prototype.has = H9;
we.prototype.set = Y9;
var G9 = we;
function J9(e, t) {
  for (var n = -1, o = e == null ? 0 : e.length; ++n < o && t(e[n], n, e) !== !1; )
    ;
  return e;
}
var X9 = J9, W9 = T1, q9 = Ot;
function e5(e, t, n, o) {
  var a = !n;
  n || (n = {});
  for (var s = -1, r = t.length; ++s < r; ) {
    var i = t[s], c = o ? o(n[i], e[i], i, n, e) : void 0;
    c === void 0 && (c = e[i]), a ? q9(n, i, c) : W9(n, i, c);
  }
  return n;
}
var r1 = e5;
function t5(e, t) {
  for (var n = -1, o = Array(e); ++n < e; )
    o[n] = t(n);
  return o;
}
var n5 = t5, o5 = ze, a5 = be, s5 = "[object Arguments]";
function i5(e) {
  return a5(e) && o5(e) == s5;
}
var r5 = i5, et = r5, c5 = be, Qt = Object.prototype, l5 = Qt.hasOwnProperty, _5 = Qt.propertyIsEnumerable, d5 = et(function() {
  return arguments;
}()) ? et : function(e) {
  return c5(e) && l5.call(e, "callee") && !_5.call(e, "callee");
}, u5 = d5, Ue = {}, $5 = {
  get exports() {
    return Ue;
  },
  set exports(e) {
    Ue = e;
  }
};
function g5() {
  return !1;
}
var h5 = g5;
(function(e, t) {
  var n = H, o = h5, a = t && !t.nodeType && t, s = a && !0 && e && !e.nodeType && e, r = s && s.exports === a, i = r ? n.Buffer : void 0, c = i ? i.isBuffer : void 0, $ = c || o;
  e.exports = $;
})($5, Ue);
var m5 = 9007199254740991;
function p5(e) {
  return typeof e == "number" && e > -1 && e % 1 == 0 && e <= m5;
}
var Zt = p5, f5 = ze, y5 = Zt, C5 = be, b5 = "[object Arguments]", v5 = "[object Array]", L5 = "[object Boolean]", x5 = "[object Date]", w5 = "[object Error]", k5 = "[object Function]", A5 = "[object Map]", T5 = "[object Number]", M5 = "[object Object]", S5 = "[object RegExp]", D5 = "[object Set]", I5 = "[object String]", B5 = "[object WeakMap]", U5 = "[object ArrayBuffer]", P5 = "[object DataView]", z5 = "[object Float32Array]", R5 = "[object Float64Array]", N5 = "[object Int8Array]", O5 = "[object Int16Array]", E5 = "[object Int32Array]", j5 = "[object Uint8Array]", F5 = "[object Uint8ClampedArray]", K5 = "[object Uint16Array]", V5 = "[object Uint32Array]", k = {};
k[z5] = k[R5] = k[N5] = k[O5] = k[E5] = k[j5] = k[F5] = k[K5] = k[V5] = !0;
k[b5] = k[v5] = k[U5] = k[L5] = k[P5] = k[x5] = k[w5] = k[k5] = k[A5] = k[T5] = k[M5] = k[S5] = k[D5] = k[I5] = k[B5] = !1;
function Q5(e) {
  return C5(e) && y5(e.length) && !!k[f5(e)];
}
var Z5 = Q5;
function H5(e) {
  return function(t) {
    return e(t);
  };
}
var I1 = H5, me = {}, Y5 = {
  get exports() {
    return me;
  },
  set exports(e) {
    me = e;
  }
};
(function(e, t) {
  var n = Pt, o = t && !t.nodeType && t, a = o && !0 && e && !e.nodeType && e, s = a && a.exports === o, r = s && n.process, i = function() {
    try {
      var c = a && a.require && a.require("util").types;
      return c || r && r.binding && r.binding("util");
    } catch {
    }
  }();
  e.exports = i;
})(Y5, me);
var G5 = Z5, J5 = I1, tt = me, nt = tt && tt.isTypedArray, X5 = nt ? J5(nt) : G5, W5 = X5, q5 = n5, es = u5, ts = Ce, ns = Ue, os = Vt, as = W5, ss = Object.prototype, is = ss.hasOwnProperty;
function rs(e, t) {
  var n = ts(e), o = !n && es(e), a = !n && !o && ns(e), s = !n && !o && !a && as(e), r = n || o || a || s, i = r ? q5(e.length, String) : [], c = i.length;
  for (var $ in e)
    (t || is.call(e, $)) && !(r && // Safari 9 has enumerable `arguments.length` in strict mode.
    ($ == "length" || // Node.js 0.10 has enumerable non-index properties on buffers.
    a && ($ == "offset" || $ == "parent") || // PhantomJS 2 has enumerable non-index properties on typed arrays.
    s && ($ == "buffer" || $ == "byteLength" || $ == "byteOffset") || // Skip index properties.
    os($, c))) && i.push($);
  return i;
}
var Ht = rs, cs = Object.prototype;
function ls(e) {
  var t = e && e.constructor, n = typeof t == "function" && t.prototype || cs;
  return e === n;
}
var B1 = ls;
function _s(e, t) {
  return function(n) {
    return e(t(n));
  };
}
var Yt = _s, ds = Yt, us = ds(Object.keys, Object), $s = us, gs = B1, hs = $s, ms = Object.prototype, ps = ms.hasOwnProperty;
function fs(e) {
  if (!gs(e))
    return hs(e);
  var t = [];
  for (var n in Object(e))
    ps.call(e, n) && n != "constructor" && t.push(n);
  return t;
}
var ys = fs, Cs = Rt, bs = Zt;
function vs(e) {
  return e != null && bs(e.length) && !Cs(e);
}
var Gt = vs, Ls = Ht, xs = ys, ws = Gt;
function ks(e) {
  return ws(e) ? Ls(e) : xs(e);
}
var U1 = ks, As = r1, Ts = U1;
function Ms(e, t) {
  return e && As(t, Ts(t), e);
}
var Ss = Ms;
function Ds(e) {
  var t = [];
  if (e != null)
    for (var n in Object(e))
      t.push(n);
  return t;
}
var Is = Ds, Bs = ye, Us = B1, Ps = Is, zs = Object.prototype, Rs = zs.hasOwnProperty;
function Ns(e) {
  if (!Bs(e))
    return Ps(e);
  var t = Us(e), n = [];
  for (var o in e)
    o == "constructor" && (t || !Rs.call(e, o)) || n.push(o);
  return n;
}
var Os = Ns, Es = Ht, js = Os, Fs = Gt;
function Ks(e) {
  return Fs(e) ? Es(e, !0) : js(e);
}
var P1 = Ks, Vs = r1, Qs = P1;
function Zs(e, t) {
  return e && Vs(t, Qs(t), e);
}
var Hs = Zs, e1 = {}, Ys = {
  get exports() {
    return e1;
  },
  set exports(e) {
    e1 = e;
  }
};
(function(e, t) {
  var n = H, o = t && !t.nodeType && t, a = o && !0 && e && !e.nodeType && e, s = a && a.exports === o, r = s ? n.Buffer : void 0, i = r ? r.allocUnsafe : void 0;
  function c($, l) {
    if (l)
      return $.slice();
    var h = $.length, f = i ? i(h) : new $.constructor(h);
    return $.copy(f), f;
  }
  e.exports = c;
})(Ys, e1);
function Gs(e, t) {
  var n = -1, o = e.length;
  for (t || (t = Array(o)); ++n < o; )
    t[n] = e[n];
  return t;
}
var Js = Gs;
function Xs(e, t) {
  for (var n = -1, o = e == null ? 0 : e.length, a = 0, s = []; ++n < o; ) {
    var r = e[n];
    t(r, n, e) && (s[a++] = r);
  }
  return s;
}
var Ws = Xs;
function qs() {
  return [];
}
var Jt = qs, ei = Ws, ti = Jt, ni = Object.prototype, oi = ni.propertyIsEnumerable, ot = Object.getOwnPropertySymbols, ai = ot ? function(e) {
  return e == null ? [] : (e = Object(e), ei(ot(e), function(t) {
    return oi.call(e, t);
  }));
} : ti, z1 = ai, si = r1, ii = z1;
function ri(e, t) {
  return si(e, ii(e), t);
}
var ci = ri;
function li(e, t) {
  for (var n = -1, o = t.length, a = e.length; ++n < o; )
    e[a + n] = t[n];
  return e;
}
var Xt = li, _i = Yt, di = _i(Object.getPrototypeOf, Object), Wt = di, ui = Xt, $i = Wt, gi = z1, hi = Jt, mi = Object.getOwnPropertySymbols, pi = mi ? function(e) {
  for (var t = []; e; )
    ui(t, gi(e)), e = $i(e);
  return t;
} : hi, qt = pi, fi = r1, yi = qt;
function Ci(e, t) {
  return fi(e, yi(e), t);
}
var bi = Ci, vi = Xt, Li = Ce;
function xi(e, t, n) {
  var o = t(e);
  return Li(e) ? o : vi(o, n(e));
}
var en = xi, wi = en, ki = z1, Ai = U1;
function Ti(e) {
  return wi(e, Ai, ki);
}
var Mi = Ti, Si = en, Di = qt, Ii = P1;
function Bi(e) {
  return Si(e, Ii, Di);
}
var Ui = Bi, Pi = ce, zi = H, Ri = Pi(zi, "DataView"), Ni = Ri, Oi = ce, Ei = H, ji = Oi(Ei, "Promise"), Fi = ji, Ki = ce, Vi = H, Qi = Ki(Vi, "Set"), Zi = Qi, Hi = ce, Yi = H, Gi = Hi(Yi, "WeakMap"), Ji = Gi, f1 = Ni, y1 = S1, C1 = Fi, b1 = Zi, v1 = Ji, tn = ze, ke = Nt, at = "[object Map]", Xi = "[object Object]", st = "[object Promise]", it = "[object Set]", rt = "[object WeakMap]", ct = "[object DataView]", Wi = ke(f1), qi = ke(y1), er = ke(C1), tr = ke(b1), nr = ke(v1), ae = tn;
(f1 && ae(new f1(new ArrayBuffer(1))) != ct || y1 && ae(new y1()) != at || C1 && ae(C1.resolve()) != st || b1 && ae(new b1()) != it || v1 && ae(new v1()) != rt) && (ae = function(e) {
  var t = tn(e), n = t == Xi ? e.constructor : void 0, o = n ? ke(n) : "";
  if (o)
    switch (o) {
      case Wi:
        return ct;
      case qi:
        return at;
      case er:
        return st;
      case tr:
        return it;
      case nr:
        return rt;
    }
  return t;
});
var R1 = ae, or = Object.prototype, ar = or.hasOwnProperty;
function sr(e) {
  var t = e.length, n = new e.constructor(t);
  return t && typeof e[0] == "string" && ar.call(e, "index") && (n.index = e.index, n.input = e.input), n;
}
var ir = sr, rr = H, cr = rr.Uint8Array, lr = cr, lt = lr;
function _r(e) {
  var t = new e.constructor(e.byteLength);
  return new lt(t).set(new lt(e)), t;
}
var N1 = _r, dr = N1;
function ur(e, t) {
  var n = t ? dr(e.buffer) : e.buffer;
  return new e.constructor(n, e.byteOffset, e.byteLength);
}
var $r = ur, gr = /\w*$/;
function hr(e) {
  var t = new e.constructor(e.source, gr.exec(e));
  return t.lastIndex = e.lastIndex, t;
}
var mr = hr, _t = n1, dt = _t ? _t.prototype : void 0, ut = dt ? dt.valueOf : void 0;
function pr(e) {
  return ut ? Object(ut.call(e)) : {};
}
var fr = pr, yr = N1;
function Cr(e, t) {
  var n = t ? yr(e.buffer) : e.buffer;
  return new e.constructor(n, e.byteOffset, e.length);
}
var br = Cr, vr = N1, Lr = $r, xr = mr, wr = fr, kr = br, Ar = "[object Boolean]", Tr = "[object Date]", Mr = "[object Map]", Sr = "[object Number]", Dr = "[object RegExp]", Ir = "[object Set]", Br = "[object String]", Ur = "[object Symbol]", Pr = "[object ArrayBuffer]", zr = "[object DataView]", Rr = "[object Float32Array]", Nr = "[object Float64Array]", Or = "[object Int8Array]", Er = "[object Int16Array]", jr = "[object Int32Array]", Fr = "[object Uint8Array]", Kr = "[object Uint8ClampedArray]", Vr = "[object Uint16Array]", Qr = "[object Uint32Array]";
function Zr(e, t, n) {
  var o = e.constructor;
  switch (t) {
    case Pr:
      return vr(e);
    case Ar:
    case Tr:
      return new o(+e);
    case zr:
      return Lr(e, n);
    case Rr:
    case Nr:
    case Or:
    case Er:
    case jr:
    case Fr:
    case Kr:
    case Vr:
    case Qr:
      return kr(e, n);
    case Mr:
      return new o();
    case Sr:
    case Br:
      return new o(e);
    case Dr:
      return xr(e);
    case Ir:
      return new o();
    case Ur:
      return wr(e);
  }
}
var Hr = Zr, Yr = ye, $t = Object.create, Gr = function() {
  function e() {
  }
  return function(t) {
    if (!Yr(t))
      return {};
    if ($t)
      return $t(t);
    e.prototype = t;
    var n = new e();
    return e.prototype = void 0, n;
  };
}(), Jr = Gr, Xr = Jr, Wr = Wt, qr = B1;
function ec(e) {
  return typeof e.constructor == "function" && !qr(e) ? Xr(Wr(e)) : {};
}
var tc = ec, nc = R1, oc = be, ac = "[object Map]";
function sc(e) {
  return oc(e) && nc(e) == ac;
}
var ic = sc, rc = ic, cc = I1, gt = me, ht = gt && gt.isMap, lc = ht ? cc(ht) : rc, _c = lc, dc = R1, uc = be, $c = "[object Set]";
function gc(e) {
  return uc(e) && dc(e) == $c;
}
var hc = gc, mc = hc, pc = I1, mt = me, pt = mt && mt.isSet, fc = pt ? pc(pt) : mc, yc = fc, Cc = G9, bc = X9, vc = T1, Lc = Ss, xc = Hs, wc = e1, kc = Js, Ac = ci, Tc = bi, Mc = Mi, Sc = Ui, Dc = R1, Ic = ir, Bc = Hr, Uc = tc, Pc = Ce, zc = Ue, Rc = _c, Nc = ye, Oc = yc, Ec = U1, jc = P1, Fc = 1, Kc = 2, Vc = 4, nn = "[object Arguments]", Qc = "[object Array]", Zc = "[object Boolean]", Hc = "[object Date]", Yc = "[object Error]", on = "[object Function]", Gc = "[object GeneratorFunction]", Jc = "[object Map]", Xc = "[object Number]", an = "[object Object]", Wc = "[object RegExp]", qc = "[object Set]", e6 = "[object String]", t6 = "[object Symbol]", n6 = "[object WeakMap]", o6 = "[object ArrayBuffer]", a6 = "[object DataView]", s6 = "[object Float32Array]", i6 = "[object Float64Array]", r6 = "[object Int8Array]", c6 = "[object Int16Array]", l6 = "[object Int32Array]", _6 = "[object Uint8Array]", d6 = "[object Uint8ClampedArray]", u6 = "[object Uint16Array]", $6 = "[object Uint32Array]", w = {};
w[nn] = w[Qc] = w[o6] = w[a6] = w[Zc] = w[Hc] = w[s6] = w[i6] = w[r6] = w[c6] = w[l6] = w[Jc] = w[Xc] = w[an] = w[Wc] = w[qc] = w[e6] = w[t6] = w[_6] = w[d6] = w[u6] = w[$6] = !0;
w[Yc] = w[on] = w[n6] = !1;
function He(e, t, n, o, a, s) {
  var r, i = t & Fc, c = t & Kc, $ = t & Vc;
  if (n && (r = a ? n(e, o, a, s) : n(e)), r !== void 0)
    return r;
  if (!Nc(e))
    return e;
  var l = Pc(e);
  if (l) {
    if (r = Ic(e), !i)
      return kc(e, r);
  } else {
    var h = Dc(e), f = h == on || h == Gc;
    if (zc(e))
      return wc(e, i);
    if (h == an || h == nn || f && !a) {
      if (r = c || f ? {} : Uc(e), !i)
        return c ? Tc(e, xc(r, e)) : Ac(e, Lc(r, e));
    } else {
      if (!w[h])
        return a ? e : {};
      r = Bc(e, h, i);
    }
  }
  s || (s = new Cc());
  var v = s.get(e);
  if (v)
    return v;
  s.set(e, r), Oc(e) ? e.forEach(function(U) {
    r.add(He(U, t, n, U, e, s));
  }) : Rc(e) && e.forEach(function(U, M) {
    r.set(M, He(U, t, n, M, e, s));
  });
  var D = $ ? c ? Sc : Mc : c ? jc : Ec, z = l ? void 0 : D(e);
  return bc(z || e, function(U, M) {
    z && (M = U, U = e[M]), vc(r, M, He(U, t, n, M, e, s));
  }), r;
}
var g6 = He, h6 = g6, m6 = 1, p6 = 4;
function f6(e) {
  return h6(e, m6 | p6);
}
var y6 = f6;
const C6 = /* @__PURE__ */ g("<button></button>"), b6 = (e) => (() => {
  const t = C6.cloneNode(!0);
  return Be(t, "click", e.onClick, !0), p(t, () => e.children), O((n) => {
    const o = e.style, a = `klinecharts-pro-button ${e.type ?? "confirm"} ${e.class ?? ""}`;
    return n._v$ = fe(t, o, n._v$), a !== n._v$2 && re(t, n._v$2 = a), n;
  }, {
    _v$: void 0,
    _v$2: void 0
  }), t;
})();
Z(["click"]);
const v6 = /* @__PURE__ */ g('<svg viewBox="0 0 1024 1024" class="icon"><path d="M810.666667 128H213.333333c-46.933333 0-85.333333 38.4-85.333333 85.333333v597.333334c0 46.933333 38.4 85.333333 85.333333 85.333333h597.333334c46.933333 0 85.333333-38.4 85.333333-85.333333V213.333333c0-46.933333-38.4-85.333333-85.333333-85.333333z m-353.706667 567.04a42.496 42.496 0 0 1-60.16 0L243.626667 541.866667c-8.106667-8.106667-12.373333-18.773333-12.373334-29.866667s4.693333-22.186667 12.373334-29.866667a42.496 42.496 0 0 1 60.16 0L426.666667 604.586667l293.546666-293.546667a42.496 42.496 0 1 1 60.16 60.16l-323.413333 323.84z"></path></svg>'), L6 = /* @__PURE__ */ g('<svg viewBox="0 0 1024 1024" class="icon"><path d="M245.333333 128h533.333334A117.333333 117.333333 0 0 1 896 245.333333v533.333334A117.333333 117.333333 0 0 1 778.666667 896H245.333333A117.333333 117.333333 0 0 1 128 778.666667V245.333333A117.333333 117.333333 0 0 1 245.333333 128z m0 64c-29.44 0-53.333333 23.893333-53.333333 53.333333v533.333334c0 29.44 23.893333 53.333333 53.333333 53.333333h533.333334c29.44 0 53.333333-23.893333 53.333333-53.333333V245.333333c0-29.44-23.893333-53.333333-53.333333-53.333333H245.333333z"></path></svg>'), x6 = /* @__PURE__ */ g("<div></div>"), w6 = /* @__PURE__ */ g('<span class="label"></span>'), k6 = () => v6.cloneNode(!0), A6 = () => L6.cloneNode(!0), ft = (e) => {
  const [t, n] = C(e.checked ?? !1);
  return J(() => {
    "checked" in e && n(e.checked);
  }), (() => {
    const o = x6.cloneNode(!0);
    return o.$$click = (a) => {
      const s = !t();
      e.onChange && e.onChange(s), n(s);
    }, p(o, (() => {
      const a = I(() => !!t());
      return () => a() ? m(k6, {}) : m(A6, {});
    })(), null), p(o, (() => {
      const a = I(() => !!e.label);
      return () => a() && (() => {
        const s = w6.cloneNode(!0);
        return p(s, () => e.label), s;
      })();
    })(), null), O((a) => {
      const s = e.style, r = `klinecharts-pro-checkbox ${t() && "checked" || ""} ${e.class || ""}`;
      return a._v$ = fe(o, s, a._v$), r !== a._v$2 && re(o, a._v$2 = r), a;
    }, {
      _v$: void 0,
      _v$2: void 0
    }), o;
  })();
};
Z(["click"]);
const T6 = /* @__PURE__ */ g('<div class="klinecharts-pro-loading"><i class="circle1"></i><i class="circle2"></i><i class="circle3"></i></div>'), sn = () => T6.cloneNode(!0), M6 = /* @__PURE__ */ g('<div class="klinecharts-pro-empty"><svg class="icon" viewBox="0 0 1024 1024"><path d="M855.6 427.2H168.5c-12.7 0-24.4 6.9-30.6 18L4.4 684.7C1.5 689.9 0 695.8 0 701.8v287.1c0 19.4 15.7 35.1 35.1 35.1H989c19.4 0 35.1-15.7 35.1-35.1V701.8c0-6-1.5-11.8-4.4-17.1L886.2 445.2c-6.2-11.1-17.9-18-30.6-18zM673.4 695.6c-16.5 0-30.8 11.5-34.3 27.7-12.7 58.5-64.8 102.3-127.2 102.3s-114.5-43.8-127.2-102.3c-3.5-16.1-17.8-27.7-34.3-27.7H119c-26.4 0-43.3-28-31.1-51.4l81.7-155.8c6.1-11.6 18-18.8 31.1-18.8h622.4c13 0 25 7.2 31.1 18.8l81.7 155.8c12.2 23.4-4.7 51.4-31.1 51.4H673.4zM819.9 209.5c-1-1.8-2.1-3.7-3.2-5.5-9.8-16.6-31.1-22.2-47.8-12.6L648.5 261c-17 9.8-22.7 31.6-12.6 48.4 0.9 1.4 1.7 2.9 2.5 4.4 9.5 17 31.2 22.8 48 13L807 257.3c16.7-9.7 22.4-31 12.9-47.8zM375.4 261.1L255 191.6c-16.7-9.6-38-4-47.8 12.6-1.1 1.8-2.1 3.6-3.2 5.5-9.5 16.8-3.8 38.1 12.9 47.8L337.3 327c16.9 9.7 38.6 4 48-13.1 0.8-1.5 1.7-2.9 2.5-4.4 10.2-16.8 4.5-38.6-12.4-48.4zM512 239.3h2.5c19.5 0.3 35.5-15.5 35.5-35.1v-139c0-19.3-15.6-34.9-34.8-35.1h-6.4C489.6 30.3 474 46 474 65.2v139c0 19.5 15.9 35.4 35.5 35.1h2.5z"></path></svg></div>'), S6 = () => M6.cloneNode(!0), D6 = /* @__PURE__ */ g("<ul></ul>"), I6 = /* @__PURE__ */ g("<li></li>"), L1 = (e) => (() => {
  const t = D6.cloneNode(!0);
  return p(t, m(j, {
    get when() {
      return e.loading;
    },
    get children() {
      return m(sn, {});
    }
  }), null), p(t, m(j, {
    get when() {
      var n;
      return !e.loading && !e.children && !((n = e.dataSource) != null && n.length);
    },
    get children() {
      return m(S6, {});
    }
  }), null), p(t, m(j, {
    get when() {
      return e.children;
    },
    get children() {
      return e.children;
    }
  }), null), p(t, m(j, {
    get when() {
      return !e.children;
    },
    get children() {
      var n;
      return (n = e.dataSource) == null ? void 0 : n.map((o) => {
        var a;
        return ((a = e.renderItem) == null ? void 0 : a.call(e, o)) ?? I6.cloneNode(!0);
      });
    }
  }), null), O((n) => {
    const o = e.style, a = `klinecharts-pro-list ${e.class ?? ""}`;
    return n._v$ = fe(t, o, n._v$), a !== n._v$2 && re(t, n._v$2 = a), n;
  }, {
    _v$: void 0,
    _v$2: void 0
  }), t;
})(), B6 = /* @__PURE__ */ g('<div class="klinecharts-pro-modal"><div class="inner"><div class="title-container"><svg class="close-icon" viewBox="0 0 1024 1024"><path d="M934.184927 199.723787 622.457206 511.452531l311.727721 311.703161c14.334473 14.229073 23.069415 33.951253 23.069415 55.743582 0 43.430138-35.178197 78.660524-78.735226 78.660524-21.664416 0-41.361013-8.865925-55.642275-23.069415L511.149121 622.838388 199.420377 934.490384c-14.204513 14.20349-33.901111 23.069415-55.642275 23.069415-43.482327 0-78.737272-35.230386-78.737272-78.660524 0-21.792329 8.864902-41.513486 23.094998-55.743582l311.677579-311.703161L88.135828 199.723787c-14.230096-14.255679-23.094998-33.92567-23.094998-55.642275 0-43.430138 35.254945-78.762855 78.737272-78.762855 21.741163 0 41.437761 8.813736 55.642275 23.069415l311.727721 311.727721L822.876842 88.389096c14.281261-14.255679 33.977859-23.069415 55.642275-23.069415 43.557028 0 78.735226 35.332716 78.735226 78.762855C957.254342 165.798117 948.5194 185.468109 934.184927 199.723787"></path></svg></div><div class="content-container"></div></div></div>'), U6 = /* @__PURE__ */ g('<div class="button-container"></div>'), Re = (e) => (() => {
  const t = B6.cloneNode(!0), n = t.firstChild, o = n.firstChild, a = o.firstChild, s = o.nextSibling;
  return p(o, () => e.title, a), Be(a, "click", e.onClose, !0), p(s, () => e.children), p(n, (() => {
    const r = I(() => !!(e.buttons && e.buttons.length > 0));
    return () => r() && (() => {
      const i = U6.cloneNode(!0);
      return p(i, () => e.buttons.map((c) => m(b6, Ut(c, {
        get children() {
          return c.children;
        }
      })))), i;
    })();
  })(), null), O(() => n.style.setProperty("width", `${e.width ?? 400}px`)), t;
})();
Z(["click"]);
const P6 = /* @__PURE__ */ g('<div tabindex="0"><div class="selector-container"><span class="value"></span><i class="arrow"></i></div></div>'), z6 = /* @__PURE__ */ g('<div class="drop-down-container"><ul></ul></div>'), R6 = /* @__PURE__ */ g("<li></li>"), rn = (e) => {
  const [t, n] = C(!1);
  return (() => {
    const o = P6.cloneNode(!0), a = o.firstChild, s = a.firstChild;
    return o.addEventListener("blur", (r) => {
      n(!1);
    }), o.$$click = (r) => {
      n((i) => !i);
    }, p(s, () => e.value), p(o, (() => {
      const r = I(() => !!(e.dataSource && e.dataSource.length > 0));
      return () => r() && (() => {
        const i = z6.cloneNode(!0), c = i.firstChild;
        return p(c, () => e.dataSource.map(($) => {
          const h = $[e.valueKey ?? "text"] ?? $;
          return (() => {
            const f = R6.cloneNode(!0);
            return f.$$click = (v) => {
              var D;
              v.stopPropagation(), e.value !== h && ((D = e.onSelected) == null || D.call(e, $)), n(!1);
            }, p(f, h), f;
          })();
        })), i;
      })();
    })(), null), O((r) => {
      const i = e.style, c = `klinecharts-pro-select ${e.class ?? ""} ${t() ? "klinecharts-pro-select-show" : ""}`;
      return r._v$ = fe(o, i, r._v$), c !== r._v$2 && re(o, r._v$2 = c), r;
    }, {
      _v$: void 0,
      _v$2: void 0
    }), o;
  })();
};
Z(["click"]);
const N6 = /* @__PURE__ */ g('<span class="prefix"></span>'), O6 = /* @__PURE__ */ g('<span class="suffix"></span>'), E6 = /* @__PURE__ */ g('<div><input class="value"></div>'), j6 = (e) => {
  const t = Ut({
    min: Number.MIN_SAFE_INTEGER,
    max: Number.MAX_SAFE_INTEGER
  }, e);
  let n;
  const [o, a] = C("normal");
  return (() => {
    const s = E6.cloneNode(!0), r = s.firstChild;
    return s.$$click = () => {
      n == null || n.focus();
    }, p(s, m(j, {
      get when() {
        return t.prefix;
      },
      get children() {
        const i = N6.cloneNode(!0);
        return p(i, () => t.prefix), i;
      }
    }), r), r.addEventListener("change", (i) => {
      var $, l;
      const c = i.target.value;
      if ("precision" in t) {
        let h;
        const f = Math.max(0, Math.floor(t.precision));
        f <= 0 ? h = new RegExp(/^[1-9]\d*$/) : h = new RegExp("^\\d+\\.?\\d{0," + f + "}$"), (c === "" || h.test(c) && +c >= t.min && +c <= t.max) && (($ = t.onChange) == null || $.call(t, c === "" ? c : +c));
      } else
        (l = t.onChange) == null || l.call(t, c);
    }), r.addEventListener("blur", () => {
      a("normal");
    }), r.addEventListener("focus", () => {
      a("focus");
    }), A1((i) => {
      n = i;
    }, r), p(s, m(j, {
      get when() {
        return t.suffix;
      },
      get children() {
        const i = O6.cloneNode(!0);
        return p(i, () => t.suffix), i;
      }
    }), null), O((i) => {
      const c = t.style, $ = `klinecharts-pro-input ${t.class ?? ""}`, l = o(), h = t.placeholder ?? "";
      return i._v$ = fe(s, c, i._v$), $ !== i._v$2 && re(s, i._v$2 = $), l !== i._v$3 && W(s, "data-status", i._v$3 = l), h !== i._v$4 && W(r, "placeholder", i._v$4 = h), i;
    }, {
      _v$: void 0,
      _v$2: void 0,
      _v$3: void 0,
      _v$4: void 0
    }), O(() => r.value = t.value), s;
  })();
};
Z(["click"]);
const F6 = /* @__PURE__ */ g('<div><i class="thumb"></i></div>'), K6 = (e) => (() => {
  const t = F6.cloneNode(!0);
  return t.$$click = (n) => {
    e.onChange && e.onChange();
  }, O((n) => {
    const o = e.style, a = `klinecharts-pro-switch ${e.open ? "turn-on" : "turn-off"} ${e.class ?? ""}`;
    return n._v$ = fe(t, o, n._v$), a !== n._v$2 && re(t, n._v$2 = a), n;
  }, {
    _v$: void 0,
    _v$2: void 0
  }), t;
})();
Z(["click"]);
const V6 = "指标", Q6 = "主图指标", Z6 = "副图指标", H6 = "设置", Y6 = "时区", G6 = "截屏", J6 = "全屏", X6 = "退出全屏", W6 = "保存", q6 = "确定", e2 = "取消", t2 = "MA(移动平均线)", n2 = "EMA(指数平滑移动平均线)", o2 = "SMA", a2 = "BOLL(布林线)", s2 = "BBI(多空指数)", i2 = "SAR(停损点指向指标)", r2 = "VOL(成交量)", c2 = "MACD(指数平滑异同移动平均线)", l2 = "KDJ(随机指标)", _2 = "RSI(相对强弱指标)", d2 = "BIAS(乖离率)", u2 = "BRAR(情绪指标)", $2 = "CCI(顺势指标)", g2 = "DMI(动向指标)", h2 = "CR(能量指标)", m2 = "PSY(心理线)", p2 = "DMA(平行线差指标)", f2 = "TRIX(三重指数平滑平均线)", y2 = "OBV(能量潮指标)", C2 = "VR(成交量变异率)", b2 = "WR(威廉指标)", v2 = "MTM(动量指标)", L2 = "EMV(简易波动指标)", x2 = "ROC(变动率指标)", w2 = "PVT(价量趋势指标)", k2 = "AO(动量震荡指标)", A2 = "世界统一时间", T2 = "(UTC-10) 檀香山", M2 = "(UTC-8) 朱诺", S2 = "(UTC-7) 洛杉矶", D2 = "(UTC-5) 芝加哥", I2 = "(UTC-4) 多伦多", B2 = "(UTC-3) 圣保罗", U2 = "(UTC+1) 伦敦", P2 = "(UTC+2) 柏林", z2 = "(UTC+3) 巴林", R2 = "(UTC+4) 迪拜", N2 = "(UTC+5) 阿什哈巴德", O2 = "(UTC+6) 阿拉木图", E2 = "(UTC+7) 曼谷", j2 = "(UTC+8) 上海", F2 = "(UTC+9) 东京", K2 = "(UTC+10) 悉尼", V2 = "(UTC+12) 诺福克岛", Q2 = "水平直线", Z2 = "水平射线", H2 = "水平线段", Y2 = "垂直直线", G2 = "垂直射线", J2 = "垂直线段", X2 = "直线", W2 = "射线", q2 = "线段", e8 = "箭头", t8 = "价格线", n8 = "价格通道线", o8 = "平行直线", a8 = "斐波那契回调直线", s8 = "斐波那契回调线段", i8 = "斐波那契圆环", r8 = "斐波那契螺旋", c8 = "斐波那契速度阻力扇", l8 = "斐波那契趋势扩展", _8 = "江恩箱", d8 = "矩形", u8 = "平行四边形", $8 = "圆", g8 = "三角形", h8 = "三浪", m8 = "五浪", p8 = "八浪", f8 = "任意浪", y8 = "ABCD形态", C8 = "XABCD形态", b8 = "弱磁模式", v8 = "强磁模式", L8 = "商品搜索", x8 = "商品代码", w8 = "参数1", k8 = "参数2", A8 = "参数3", T8 = "参数4", M8 = "参数5", S8 = "周期", D8 = "标准差", I8 = "蜡烛图类型", B8 = "全实心", U8 = "全空心", P8 = "涨空心", z8 = "跌空心", R8 = "OHLC", N8 = "面积图", O8 = "最新价显示", E8 = "最高价显示", j8 = "最低价显示", F8 = "指标最新值显示", K8 = "价格轴类型", V8 = "线性轴", Q8 = "百分比轴", Z8 = "对数轴", H8 = "倒置坐标", Y8 = "网格线显示", G8 = "恢复默认", J8 = {
  indicator: V6,
  main_indicator: Q6,
  sub_indicator: Z6,
  setting: H6,
  timezone: Y6,
  screenshot: G6,
  full_screen: J6,
  exit_full_screen: X6,
  save: W6,
  confirm: q6,
  cancel: e2,
  ma: t2,
  ema: n2,
  sma: o2,
  boll: a2,
  bbi: s2,
  sar: i2,
  vol: r2,
  macd: c2,
  kdj: l2,
  rsi: _2,
  bias: d2,
  brar: u2,
  cci: $2,
  dmi: g2,
  cr: h2,
  psy: m2,
  dma: p2,
  trix: f2,
  obv: y2,
  vr: C2,
  wr: b2,
  mtm: v2,
  emv: L2,
  roc: x2,
  pvt: w2,
  ao: k2,
  utc: A2,
  honolulu: T2,
  juneau: M2,
  los_angeles: S2,
  chicago: D2,
  toronto: I2,
  sao_paulo: B2,
  london: U2,
  berlin: P2,
  bahrain: z2,
  dubai: R2,
  ashkhabad: N2,
  almaty: O2,
  bangkok: E2,
  shanghai: j2,
  tokyo: F2,
  sydney: K2,
  norfolk: V2,
  horizontal_straight_line: Q2,
  horizontal_ray_line: Z2,
  horizontal_segment: H2,
  vertical_straight_line: Y2,
  vertical_ray_line: G2,
  vertical_segment: J2,
  straight_line: X2,
  ray_line: W2,
  segment: q2,
  arrow: e8,
  price_line: t8,
  price_channel_line: n8,
  parallel_straight_line: o8,
  fibonacci_line: a8,
  fibonacci_segment: s8,
  fibonacci_circle: i8,
  fibonacci_spiral: r8,
  fibonacci_speed_resistance_fan: c8,
  fibonacci_extension: l8,
  gann_box: _8,
  rect: d8,
  parallelogram: u8,
  circle: $8,
  triangle: g8,
  three_waves: h8,
  five_waves: m8,
  eight_waves: p8,
  any_waves: f8,
  abcd: y8,
  xabcd: C8,
  weak_magnet: b8,
  strong_magnet: v8,
  symbol_search: L8,
  symbol_code: x8,
  params_1: w8,
  params_2: k8,
  params_3: A8,
  params_4: T8,
  params_5: M8,
  period: S8,
  standard_deviation: D8,
  candle_type: I8,
  candle_solid: B8,
  candle_stroke: U8,
  candle_up_stroke: P8,
  candle_down_stroke: z8,
  ohlc: R8,
  area: N8,
  last_price_show: O8,
  high_price_show: E8,
  low_price_show: j8,
  indicator_last_value_show: F8,
  price_axis_type: K8,
  normal: V8,
  percentage: Q8,
  log: Z8,
  reverse_coordinate: H8,
  grid_show: Y8,
  restore_default: G8
}, X8 = "Indicator", W8 = "Main Indicator", q8 = "Sub Indicator", e3 = "Setting", t3 = "Timezone", n3 = "Screenshot", o3 = "Full Screen", a3 = "Exit", s3 = "Save", i3 = "Confirm", r3 = "Cancel", c3 = "MA(Moving Average)", l3 = "EMA(Exponential Moving Average)", _3 = "SMA", d3 = "BOLL(Bolinger Bands)", u3 = "BBI(Bull And Bearlndex)", $3 = "SAR(Stop and Reverse)", g3 = "VOL(Volume)", h3 = "MACD(Moving Average Convergence / Divergence)", m3 = "KDJ(KDJ Index)", p3 = "RSI(Relative Strength Index)", f3 = "BIAS(Bias Ratio)", y3 = "BRAR (Sentiment Indicator)", C3 = "CCI(Commodity Channel Index)", b3 = "DMI(Directional Movement Index)", v3 = "CR (Energy indicator)", L3 = "PSY(Psychological Line)", x3 = "DMA(Different of Moving Average)", w3 = "TRIX(Triple Exponentially Smoothed Moving Average)", k3 = "OBV(On Balance Volume)", A3 = "VR(Volatility Volume Ratio)", T3 = "WR(Williams %R)", M3 = "MTM(Momentum Index)", S3 = "EMV(Ease of Movement Value)", D3 = "ROC(Price Rate of Change)", I3 = "PVT(Price and Volume Trend)", B3 = "AO(Awesome Oscillator)", U3 = "UTC", P3 = "(UTC-10) Honolulu", z3 = "(UTC-8) Juneau", R3 = "(UTC-7) Los Angeles", N3 = "(UTC-5) Chicago", O3 = "(UTC-4) Toronto", E3 = "(UTC-3) Sao Paulo", j3 = "(UTC+1) London", F3 = "(UTC+2) Berlin", K3 = "(UTC+3) Bahrain", V3 = "(UTC+4) Dubai", Q3 = "(UTC+5) Ashkhabad", Z3 = "(UTC+6) Almaty", H3 = "(UTC+7) Bangkok", Y3 = "(UTC+8) Shanghai", G3 = "(UTC+9) Tokyo", J3 = "(UTC+10) Sydney", X3 = "(UTC+12) Norfolk", W3 = "Horizontal Line", q3 = "Horizontal Ray", e7 = "Horizontal Segment", t7 = "Vertical Line", n7 = "Vertical Ray", o7 = "Vertical Segment", a7 = "Trend Line", s7 = "Ray", i7 = "Segment", r7 = "Arrow", c7 = "Price Line", l7 = "Price Channel Line", _7 = "Parallel Line", d7 = "Fibonacci Line", u7 = "Fibonacci Segment", $7 = "Fibonacci Circle", g7 = "Fibonacci Spiral", h7 = "Fibonacci Sector", m7 = "Fibonacci Extension", p7 = "Gann Box", f7 = "Rect", y7 = "Parallelogram", C7 = "Circle", b7 = "Triangle", v7 = "Three Waves", L7 = "Five Waves", x7 = "Eight Waves", w7 = "Any Waves", k7 = "ABCD Pattern", A7 = "XABCD Pattern", T7 = "Weak Magnet", M7 = "Strong Magnet", S7 = "Period", D7 = "Standard Deviation", I7 = "Candlestick Type", B7 = "Solid", U7 = "Hollow", P7 = "Rising Hollow", z7 = "Falling Hollow", R7 = "OHLC", N7 = "Area", O7 = "Last Price Display", E7 = "High Price Display", j7 = "Low Price Display", F7 = "Indicator Last Value Display", K7 = "Price Axis Type", V7 = "Linear Axis", Q7 = "Percentage Axis", Z7 = "Logarithmic Axis", H7 = "Inverted Coordinates", Y7 = "Grid Line Display", G7 = "Restore Default", J7 = "Product Search", X7 = "Product Code", W7 = {
  indicator: X8,
  main_indicator: W8,
  sub_indicator: q8,
  setting: e3,
  timezone: t3,
  screenshot: n3,
  full_screen: o3,
  exit_full_screen: a3,
  save: s3,
  confirm: i3,
  cancel: r3,
  ma: c3,
  ema: l3,
  sma: _3,
  boll: d3,
  bbi: u3,
  sar: $3,
  vol: g3,
  macd: h3,
  kdj: m3,
  rsi: p3,
  bias: f3,
  brar: y3,
  cci: C3,
  dmi: b3,
  cr: v3,
  psy: L3,
  dma: x3,
  trix: w3,
  obv: k3,
  vr: A3,
  wr: T3,
  mtm: M3,
  emv: S3,
  roc: D3,
  pvt: I3,
  ao: B3,
  utc: U3,
  honolulu: P3,
  juneau: z3,
  los_angeles: R3,
  chicago: N3,
  toronto: O3,
  sao_paulo: E3,
  london: j3,
  berlin: F3,
  bahrain: K3,
  dubai: V3,
  ashkhabad: Q3,
  almaty: Z3,
  bangkok: H3,
  shanghai: Y3,
  tokyo: G3,
  sydney: J3,
  norfolk: X3,
  horizontal_straight_line: W3,
  horizontal_ray_line: q3,
  horizontal_segment: e7,
  vertical_straight_line: t7,
  vertical_ray_line: n7,
  vertical_segment: o7,
  straight_line: a7,
  ray_line: s7,
  segment: i7,
  arrow: r7,
  price_line: c7,
  price_channel_line: l7,
  parallel_straight_line: _7,
  fibonacci_line: d7,
  fibonacci_segment: u7,
  fibonacci_circle: $7,
  fibonacci_spiral: g7,
  fibonacci_speed_resistance_fan: h7,
  fibonacci_extension: m7,
  gann_box: p7,
  rect: f7,
  parallelogram: y7,
  circle: C7,
  triangle: b7,
  three_waves: v7,
  five_waves: L7,
  eight_waves: x7,
  any_waves: w7,
  abcd: k7,
  xabcd: A7,
  weak_magnet: T7,
  strong_magnet: M7,
  period: S7,
  standard_deviation: D7,
  candle_type: I7,
  candle_solid: B7,
  candle_stroke: U7,
  candle_up_stroke: P7,
  candle_down_stroke: z7,
  ohlc: R7,
  area: N7,
  last_price_show: O7,
  high_price_show: E7,
  low_price_show: j7,
  indicator_last_value_show: F7,
  price_axis_type: K7,
  normal: V7,
  percentage: Q7,
  log: Z7,
  reverse_coordinate: H7,
  grid_show: Y7,
  restore_default: G7,
  symbol_search: J7,
  symbol_code: X7
}, q7 = "إشارة إشارة", el = "المؤشر الرئيسي", tl = "المؤشرات الفرعية", nl = "معلومات أساسية", ol = "المنطقة الزمنية", al = "لقطة", sl = "عرض كامل الشاشة", il = "تصدير", rl = "أنقذ", cl = "أكّد", ll = "ألغى", _l = "المتوسطات المتحركة", dl = "المتوسط المتحرك الأسي", ul = "سما", $l = "بولينجر باند", gl = "الثور الدب مؤشر", hl = "سار ( وقوف السيارات وعكس )", ml = "فل ( حجم )", pl = "الماكد ( المتوسط المتحرك التقارب / الاختلاف )", fl = "KDJ ( KDJ مؤشر )", yl = "مؤشر القوة النسبية", Cl = "نسبة التحيز", bl = "مؤشر المزاج", vl = "مؤشر السلع قناة", Ll = "مؤشر الاتجاه", xl = "CR ( مؤشر الطاقة )", wl = "الخط النفسي", kl = "DMA ( مختلفة من المتوسط المتحرك )", Al = "الثلاثي المتوسط المتحرك الاسي", Tl = "OBV ( التوازن في حجم التداول )", Ml = "الواقع الافتراضي ( تقلب نسبة )", Sl = "دبليو آر وليامز", Dl = "MTM ( الزخم مؤشر )", Il = "من السهل نقل القيمة", Bl = "جمهورية الصين ( سعر التغيير )", Ul = "الجندي ( السعر والكمية الاتجاه )", Pl = "او ( المذبذب الرائع )", zl = "قابض", Rl = "( UTC-10 ) هونولولو", Nl = "( UTC-8 ) جونو", Ol = "( UTC-7 ) لوس أنجلوس", El = "( UTC-5 ) شيكاغو", jl = "( UTC-4 ) تورونتو", Fl = "( UTC-3 ) ساو باولو", Kl = "( بالتوقيت العالمي + 1 ) لندن", Vl = "( بالتوقيت العالمي + 2 ) برلين", Ql = "( بالتوقيت العالمي + 3 ) البحرين", Zl = "( التوقيت العالمي + 4 ) دبي", Hl = "عشق آباد", Yl = "( بالتوقيت العالمي + 6 ) ألماتي", Gl = "( بالتوقيت العالمي + 7 ) بانكوك", Jl = "( بالتوقيت العالمي + 8 ) شنغهاي", Xl = "( بالتوقيت العالمي + 9 ) طوكيو", Wl = "( بالتوقيت العالمي + 10 ) سيدني", ql = "( بالتوقيت العالمي + 12 ) نورفولك", e4 = "خط أفقي", t4 = "أفقي راي", n4 = "الجزء الأفقي", o4 = "خط عمودي", a4 = "عمودي راي", s4 = "الجزء الرأسي", i4 = "خط الاتجاه", r4 = "راي .", c4 = "قسم", l4 = "السهام", _4 = "سعر الخط", d4 = "سعر خط القناة", u4 = "خط مواز", $4 = "خط فيبوناتشي", g4 = "قسم فيبوناتشي", h4 = "دائرة فيبوناتشي", m4 = "فيبوناتشي دوامة", p4 = "فيبوناتشي القطاع", f4 = "تمديد فيبوناتشي", y4 = "جان بوكس", C4 = "شركة Rect", b4 = "متوازي الأضلاع", v4 = "دائرة", L4 = "مثلثات", x4 = "ثلاث موجات", w4 = "خمس موجات", k4 = "ثمانية موجات", A4 = "أي موجة", T4 = "ون جيان باترن", M4 = "XABCD واسطة", S4 = "ضعف المغناطيس", D4 = "مغناطيس قوي", I4 = "فترة", B4 = "الانحراف المعياري", U4 = "شمعة عصا نوع", P4 = "صلب .", z4 = "أجوف", R4 = "ارتفاع الجوف", N4 = "هبوط الجوف", O4 = "أوم ش", E4 = "منطقة", j4 = "عرض آخر سعر", F4 = "ارتفاع سعر العرض", K4 = "عرض منخفضة التكلفة", V4 = "عرض آخر قيمة المؤشر", Q4 = "نوع المحور السعر", Z4 = "المحور الخطي", H4 = "نسبة المحور", Y4 = "زوج من المحاور", G4 = "عكس تنسيق", J4 = "شبكة خط العرض", X4 = "استعادة القيم الافتراضية", W4 = "البحث عن المنتجات", q4 = "رمز المنتج", e_ = {
  indicator: q7,
  main_indicator: el,
  sub_indicator: tl,
  setting: nl,
  timezone: ol,
  screenshot: al,
  full_screen: sl,
  exit_full_screen: il,
  save: rl,
  confirm: cl,
  cancel: ll,
  ma: _l,
  ema: dl,
  sma: ul,
  boll: $l,
  bbi: gl,
  sar: hl,
  vol: ml,
  macd: pl,
  kdj: fl,
  rsi: yl,
  bias: Cl,
  brar: bl,
  cci: vl,
  dmi: Ll,
  cr: xl,
  psy: wl,
  dma: kl,
  trix: Al,
  obv: Tl,
  vr: Ml,
  wr: Sl,
  mtm: Dl,
  emv: Il,
  roc: Bl,
  pvt: Ul,
  ao: Pl,
  utc: zl,
  honolulu: Rl,
  juneau: Nl,
  los_angeles: Ol,
  chicago: El,
  toronto: jl,
  sao_paulo: Fl,
  london: Kl,
  berlin: Vl,
  bahrain: Ql,
  dubai: Zl,
  ashkhabad: Hl,
  almaty: Yl,
  bangkok: Gl,
  shanghai: Jl,
  tokyo: Xl,
  sydney: Wl,
  norfolk: ql,
  horizontal_straight_line: e4,
  horizontal_ray_line: t4,
  horizontal_segment: n4,
  vertical_straight_line: o4,
  vertical_ray_line: a4,
  vertical_segment: s4,
  straight_line: i4,
  ray_line: r4,
  segment: c4,
  arrow: l4,
  price_line: _4,
  price_channel_line: d4,
  parallel_straight_line: u4,
  fibonacci_line: $4,
  fibonacci_segment: g4,
  fibonacci_circle: h4,
  fibonacci_spiral: m4,
  fibonacci_speed_resistance_fan: p4,
  fibonacci_extension: f4,
  gann_box: y4,
  rect: C4,
  parallelogram: b4,
  circle: v4,
  triangle: L4,
  three_waves: x4,
  five_waves: w4,
  eight_waves: k4,
  any_waves: A4,
  abcd: T4,
  xabcd: M4,
  weak_magnet: S4,
  strong_magnet: D4,
  period: I4,
  standard_deviation: B4,
  candle_type: U4,
  candle_solid: P4,
  candle_stroke: z4,
  candle_up_stroke: R4,
  candle_down_stroke: N4,
  ohlc: O4,
  area: E4,
  last_price_show: j4,
  high_price_show: F4,
  low_price_show: K4,
  indicator_last_value_show: V4,
  price_axis_type: Q4,
  normal: Z4,
  percentage: H4,
  log: Y4,
  reverse_coordinate: G4,
  grid_show: J4,
  restore_default: X4,
  symbol_search: W4,
  symbol_code: q4
}, t_ = "Indikator", n_ = "Hauptindikator", o_ = "Unterindikator", a_ = "Einstellung", s_ = "Zeitzone", i_ = "Screenshot", r_ = "Vollbild", c_ = "Verlassen", l_ = "Speichern", __ = "Bestätigen", d_ = "Abbrechen", u_ = "MA(gleitender Durchschnitt)", $_ = "EMA (Exponentieller gleitender Durchschnitt)", g_ = "SMA", h_ = "BOLL(Bolinger Bänder)", m_ = "BBI (Bull And Bearlndex)", p_ = "SAR(Stop und Reverse)", f_ = "VOL(Volumen)", y_ = "MACD (Moving Average Convergence and Divergence)", C_ = "KDJ(KDJ Index)", b_ = "RSI(Relative Strength Index)", v_ = "BIAS(Bias Ratio)", L_ = "BRAR (Stimmungsindikator)", x_ = "CCI (Commodity Channel Index)", w_ = "DMI(Directional Movement Index)", k_ = "CR (Energieindikator)", A_ = "PSY(Psychologische Linie)", T_ = "DMA (Differenz des gleitenden Durchschnitts)", M_ = "TRIX (Triple Exponential Smoothed Moving Average)", S_ = "OBV(On Balance Volume)", D_ = "VR(Volatility Volume Ratio)", I_ = "WR(Williams%R)", B_ = "MTM(Momentum Index)", U_ = "EMV (ease of movement value)", P_ = "ROC(Preisänderungsrate)", z_ = "PVT(Preis- und Volumenentwicklung)", R_ = "AO(Toller Oszillator)", N_ = "UTC", O_ = "(UTC-10) Honolulu", E_ = "(UTC-8) Juneau", j_ = "(UTC-7) Los Angeles", F_ = "(UTC-5) Chicago", K_ = "(UTC-4) Toronto", V_ = "(UTC-3) Sao Paulo", Q_ = "(UTC+1) London", Z_ = "(UTC+2) Berlin", H_ = "(UTC+3) Bahrain", Y_ = "(UTC+4) Dubai", G_ = "(UTC+5) Ashkhabad", J_ = "(UTC+6) Almaty", X_ = "(UTC+7) Bangkok", W_ = "(UTC+8) Shanghai", q_ = "(UTC+9) Tokio", ed = "(UTC+10) Sydney", td = "(UTC+12) Norfolk", nd = "Horizontale Linie", od = "Horizontaler Strahl", ad = "Horizontales Segment", sd = "Vertikale Linie", id = "Vertikaler Strahl", rd = "Vertikales Segment", cd = "Trendlinie", ld = "Ray", _d = "Segment", dd = "Pfeil", ud = "Preislinie", $d = "Preis Kanallinie", gd = "Parallele Linie", hd = "Fibonacci-Linie", md = "Fibonacci-Segment", pd = "Fibonacci-Kreis", fd = "Fibonacci Spirale", yd = "Fibonacci-Sektor", Cd = "Fibonacci-Erweiterung", bd = "Gann-Box", vd = "Rekt", Ld = "Parallelogramm", xd = "Kreis", wd = "Dreieck", kd = "Drei Wellen", Ad = "Fünf Wellen", Td = "Acht Wellen", Md = "Alle Wellen", Sd = "ABCD-Muster", Dd = "XABCD-Muster", Id = "Schwacher Magnet", Bd = "Starker Magnet", Ud = "Zeitraum", Pd = "Standardabweichung", zd = "Kerzentyp", Rd = "Fest", Nd = "Hohl", Od = "Rising Hollow", Ed = "Falling Hollow", jd = "OHLC", Fd = "Fläche", Kd = "Anzeige des letzten Preises", Vd = "Hochpreisanzeige", Qd = "Niedrigpreisanzeige", Zd = "Anzeige des letzten Wertes des Indikators", Hd = "Typ der Preisachse", Yd = "Linearachse", Gd = "Prozentachse", Jd = "Logarithmische Achse", Xd = "Invertierte Koordinaten", Wd = "Rasterlinien-Anzeige", qd = "Standard wiederherstellen", eu = "Produktsuche", tu = "Produktcode", nu = {
  indicator: t_,
  main_indicator: n_,
  sub_indicator: o_,
  setting: a_,
  timezone: s_,
  screenshot: i_,
  full_screen: r_,
  exit_full_screen: c_,
  save: l_,
  confirm: __,
  cancel: d_,
  ma: u_,
  ema: $_,
  sma: g_,
  boll: h_,
  bbi: m_,
  sar: p_,
  vol: f_,
  macd: y_,
  kdj: C_,
  rsi: b_,
  bias: v_,
  brar: L_,
  cci: x_,
  dmi: w_,
  cr: k_,
  psy: A_,
  dma: T_,
  trix: M_,
  obv: S_,
  vr: D_,
  wr: I_,
  mtm: B_,
  emv: U_,
  roc: P_,
  pvt: z_,
  ao: R_,
  utc: N_,
  honolulu: O_,
  juneau: E_,
  los_angeles: j_,
  chicago: F_,
  toronto: K_,
  sao_paulo: V_,
  london: Q_,
  berlin: Z_,
  bahrain: H_,
  dubai: Y_,
  ashkhabad: G_,
  almaty: J_,
  bangkok: X_,
  shanghai: W_,
  tokyo: q_,
  sydney: ed,
  norfolk: td,
  horizontal_straight_line: nd,
  horizontal_ray_line: od,
  horizontal_segment: ad,
  vertical_straight_line: sd,
  vertical_ray_line: id,
  vertical_segment: rd,
  straight_line: cd,
  ray_line: ld,
  segment: _d,
  arrow: dd,
  price_line: ud,
  price_channel_line: $d,
  parallel_straight_line: gd,
  fibonacci_line: hd,
  fibonacci_segment: md,
  fibonacci_circle: pd,
  fibonacci_spiral: fd,
  fibonacci_speed_resistance_fan: yd,
  fibonacci_extension: Cd,
  gann_box: bd,
  rect: vd,
  parallelogram: Ld,
  circle: xd,
  triangle: wd,
  three_waves: kd,
  five_waves: Ad,
  eight_waves: Td,
  any_waves: Md,
  abcd: Sd,
  xabcd: Dd,
  weak_magnet: Id,
  strong_magnet: Bd,
  period: Ud,
  standard_deviation: Pd,
  candle_type: zd,
  candle_solid: Rd,
  candle_stroke: Nd,
  candle_up_stroke: Od,
  candle_down_stroke: Ed,
  ohlc: jd,
  area: Fd,
  last_price_show: Kd,
  high_price_show: Vd,
  low_price_show: Qd,
  indicator_last_value_show: Zd,
  price_axis_type: Hd,
  normal: Yd,
  percentage: Gd,
  log: Jd,
  reverse_coordinate: Xd,
  grid_show: Wd,
  restore_default: qd,
  symbol_search: eu,
  symbol_code: tu
}, ou = "Señal de indicación", au = "Indicador principal", su = "Subindicadores", iu = "Antecedentes", ru = "Zona horaria", cu = "Captura de pantalla", lu = "Pantalla completa", _u = "Exportaciones", du = "Salvar", uu = "Confirmado", $u = "Cancelación", gu = "Línea media móvil", hu = "Media móvil exponencial", mu = "Smar", pu = "Cinturón de polinger", fu = "Índice niuxiong", yu = "SAR (estacionamiento y marcha atrás)", Cu = "Vol (volumen)", bu = "MACD (convergencia / divergencia de la media móvil)", vu = "Kdj (índice kdj)", Lu = "Índice de intensidad relativa", xu = "Relación de sesgo", wu = "Indicadores emocionales", ku = "Índice de canales de productos básicos", Au = "Índice de movimiento direccional", Tu = "CR (indicador de energía)", Mu = "Línea psicológica", Su = "DMA (diferente de la media móvil)", Du = "Tres índices suavizan la media móvil", Iu = "OBV (volumen de transacciones equilibrado)", Bu = "VR (tasa de volatilidad)", Uu = "WR (williams% r)", Pu = "MTM (índice de impulso)", zu = "Valor móvil", Ru = "ROC (tasa de variación de precios)", Nu = "Pvt (tendencias de precios y cantidades)", Ou = "Ao (excelente oscilador)", Eu = "Embrague", ju = "(utc - 10) Honolulu", Fu = "(utc - 8) Juno", Ku = "(utc - 7) Los Ángeles", Vu = "(utc - 5) Chicago", Qu = "(utc - 4) Toronto", Zu = "(utc - 3) Sao Paulo", Hu = "(utc + 1) Londres", Yu = "(utc + 2) Berlín", Gu = "(utc + 3) Bahréin", Ju = "(utc + 4) Dubai", Xu = "(utc + 5) Ashgabad", Wu = "(utc + 6) Almaty", qu = "(utc + 7) Bangkok", e$ = "(utc + 8) Shanghai", t$ = "(utc + 9) Tokio", n$ = "(utc + 10) Sydney", o$ = "(utc + 12) Norfolk", a$ = "Línea horizontal", s$ = "Rayos horizontales", i$ = "Segmento horizontal", r$ = "Línea vertical", c$ = "Rayos verticales", l$ = "Segmento vertical", _$ = "Línea de tendencia", d$ = "Rayos", u$ = "Sección", $$ = "Flechas", g$ = "Línea de precios", h$ = "Línea de canal de precios", m$ = "Líneas paralelas", p$ = "Línea de Fibonacci", f$ = "Sección de Fibonacci", y$ = "Círculo de Fibonacci", C$ = "Espiral de Fibonacci", b$ = "Sector de Fibonacci", v$ = "Extensión de Fibonacci", L$ = "Caja Gann", x$ = "Rect", w$ = "Paralelogramo", k$ = "Círculo", A$ = "Triángulo", T$ = "Tres olas", M$ = "Cinco olas", S$ = "Ocho olas", D$ = "Cualquier ola", I$ = "Patrón Wen Jian", B$ = "Modo xabcd", U$ = "Imán débil", P$ = "Imán fuerte", z$ = "Período", R$ = "Desviación estándar", N$ = "Tipo de palo de vela", O$ = "Sólido", E$ = "Vacío", j$ = "Hueco ascendente", F$ = "Cae hueco", K$ = "OMC LC", V$ = "Región", Q$ = "La última vez que se mostró el precio", Z$ = "Pantalla de alto precio", H$ = "Pantalla de bajo precio", Y$ = "Muestra el último valor del indicador", G$ = "Tipo de eje de precios", J$ = "Eje lineal", X$ = "Eje porcentual", W$ = "Eje de cuenta", q$ = "Coordenadas inversas", eg = "Visualización de líneas de cuadrícula", tg = "Restaurar los valores predeterminados", ng = "Búsqueda de productos", og = "Código del producto", ag = {
  indicator: ou,
  main_indicator: au,
  sub_indicator: su,
  setting: iu,
  timezone: ru,
  screenshot: cu,
  full_screen: lu,
  exit_full_screen: _u,
  save: du,
  confirm: uu,
  cancel: $u,
  ma: gu,
  ema: hu,
  sma: mu,
  boll: pu,
  bbi: fu,
  sar: yu,
  vol: Cu,
  macd: bu,
  kdj: vu,
  rsi: Lu,
  bias: xu,
  brar: wu,
  cci: ku,
  dmi: Au,
  cr: Tu,
  psy: Mu,
  dma: Su,
  trix: Du,
  obv: Iu,
  vr: Bu,
  wr: Uu,
  mtm: Pu,
  emv: zu,
  roc: Ru,
  pvt: Nu,
  ao: Ou,
  utc: Eu,
  honolulu: ju,
  juneau: Fu,
  los_angeles: Ku,
  chicago: Vu,
  toronto: Qu,
  sao_paulo: Zu,
  london: Hu,
  berlin: Yu,
  bahrain: Gu,
  dubai: Ju,
  ashkhabad: Xu,
  almaty: Wu,
  bangkok: qu,
  shanghai: e$,
  tokyo: t$,
  sydney: n$,
  norfolk: o$,
  horizontal_straight_line: a$,
  horizontal_ray_line: s$,
  horizontal_segment: i$,
  vertical_straight_line: r$,
  vertical_ray_line: c$,
  vertical_segment: l$,
  straight_line: _$,
  ray_line: d$,
  segment: u$,
  arrow: $$,
  price_line: g$,
  price_channel_line: h$,
  parallel_straight_line: m$,
  fibonacci_line: p$,
  fibonacci_segment: f$,
  fibonacci_circle: y$,
  fibonacci_spiral: C$,
  fibonacci_speed_resistance_fan: b$,
  fibonacci_extension: v$,
  gann_box: L$,
  rect: x$,
  parallelogram: w$,
  circle: k$,
  triangle: A$,
  three_waves: T$,
  five_waves: M$,
  eight_waves: S$,
  any_waves: D$,
  abcd: I$,
  xabcd: B$,
  weak_magnet: U$,
  strong_magnet: P$,
  period: z$,
  standard_deviation: R$,
  candle_type: N$,
  candle_solid: O$,
  candle_stroke: E$,
  candle_up_stroke: j$,
  candle_down_stroke: F$,
  ohlc: K$,
  area: V$,
  last_price_show: Q$,
  high_price_show: Z$,
  low_price_show: H$,
  indicator_last_value_show: Y$,
  price_axis_type: G$,
  normal: J$,
  percentage: X$,
  log: W$,
  reverse_coordinate: q$,
  grid_show: eg,
  restore_default: tg,
  symbol_search: ng,
  symbol_code: og
}, sg = "Signal d'indication", ig = "Indicateur principal", rg = "Sous - indicateurs", cg = "Contexte", lg = "Fuseau horaire", _g = "Capture d'écran", dg = "Affichage plein écran", ug = "Exportations", $g = "Sauver", gg = "Confirmé", hg = "Annulation", mg = "Moyenne mobile", pg = "Moyenne mobile exponentielle", fg = "SMA", yg = "La ceinture paulinger", Cg = "Indice des ours bovins", bg = "SAR (stationnement et marche arrière)", vg = "Vol (volume)", Lg = "Macd (convergence / divergence des moyennes mobiles)", xg = "Kdj (indice kdj)", wg = "Indice de force relative", kg = "Ratio de biais", Ag = "Indicateurs émotionnels", Tg = "Indice des canaux de marchandises", Mg = "Indice de mouvement directionnel", Sg = "CR (indicateur d'énergie)", Dg = "Ligne psychologique", Ig = "DMA (différent de la moyenne mobile)", Bg = "Moyenne mobile lissée à trois indices", Ug = "OBV (volume équilibré)", Pg = "VR (taux de volatilité)", zg = "WR (Williams% r)", Rg = "MTM (indice de momentum)", Ng = "Valeur mobile facile", Og = "Roc (taux de variation des prix)", Eg = "Pvt (tendance des prix et des quantités)", jg = "Ao (excellent oscillateur)", Fg = "Embrayage", Kg = "(UTC - 10) Honolulu", Vg = "(UTC - 8) Juneau", Qg = "(UTC - 7) à Los Angeles", Zg = "(UTC - 5) à Chicago", Hg = "(UTC - 4) Toronto", Yg = "(UTC - 3) São Paulo", Gg = "(UTC + 1) Londres", Jg = "(UTC + 2) à Berlin", Xg = "(UTC + 3) Bahreïn", Wg = "(UTC + 4) Dubaï", qg = "(UTC + 5) Ashgabat", eh = "(UTC + 6) Almaty", th = "(UTC + 7) Bangkok", nh = "(UTC + 8) à Shanghai", oh = "(UTC + 9) Tokyo", ah = "(UTC + 10) Sydney", sh = "(UTC + 12) Norfolk", ih = "Ligne horizontale", rh = "Rayons horizontaux", ch = "Segment Horizontal", lh = "Ligne verticale", _h = "Rayons verticaux", dh = "Segment de ligne vertical", uh = "Ligne de tendance", $h = "Les rayons", gh = "Segments", hh = "Les flèches", mh = "Ligne de prix", ph = "Ligne de canal de prix", fh = "Lignes parallèles", yh = "Ligne Fibonacci", Ch = "Le paragraphe Fibonacci", bh = "Cercle de Fibonacci", vh = "Spirale de Fibonacci", Lh = "Secteur Fibonacci", xh = "Extension de Fibonacci", wh = "Boîte gann", kh = "La société Rect", Ah = "Parallélogramme", Th = "Le cercle", Mh = "Le triangle", Sh = "Les trois vagues", Dh = "Les cinq vagues", Ih = "Les huit vagues", Bh = "Toute vague", Uh = "Modèle Wen Jian", Ph = "Mode xabcd", zh = "Aimants faibles", Rh = "Aimants puissants", Nh = "Période", Oh = "Déviation standard", Eh = "Types de bâtonnets de bougie", jh = "Solide", Fh = "Le vide", Kh = "Le creux ascendant", Vh = "Chute du creux", Qh = "Ohm LC", Zh = "Région", Hh = "Dernier prix affiché", Yh = "Affichage à prix élevé", Gh = "Affichage à bas prix", Jh = "Affichage de la dernière valeur de l'indicateur", Xh = "Type d'axe de prix", Wh = "Axe linéaire", qh = "Axe des pourcentages", em = "Contre l'axe des nombres", tm = "Coordonnées inversées", nm = "Affichage des lignes de grille", om = "Restaurer les valeurs par défaut", am = "Recherche de produits", sm = "Code du produit", im = {
  indicator: sg,
  main_indicator: ig,
  sub_indicator: rg,
  setting: cg,
  timezone: lg,
  screenshot: _g,
  full_screen: dg,
  exit_full_screen: ug,
  save: $g,
  confirm: gg,
  cancel: hg,
  ma: mg,
  ema: pg,
  sma: fg,
  boll: yg,
  bbi: Cg,
  sar: bg,
  vol: vg,
  macd: Lg,
  kdj: xg,
  rsi: wg,
  bias: kg,
  brar: Ag,
  cci: Tg,
  dmi: Mg,
  cr: Sg,
  psy: Dg,
  dma: Ig,
  trix: Bg,
  obv: Ug,
  vr: Pg,
  wr: zg,
  mtm: Rg,
  emv: Ng,
  roc: Og,
  pvt: Eg,
  ao: jg,
  utc: Fg,
  honolulu: Kg,
  juneau: Vg,
  los_angeles: Qg,
  chicago: Zg,
  toronto: Hg,
  sao_paulo: Yg,
  london: Gg,
  berlin: Jg,
  bahrain: Xg,
  dubai: Wg,
  ashkhabad: qg,
  almaty: eh,
  bangkok: th,
  shanghai: nh,
  tokyo: oh,
  sydney: ah,
  norfolk: sh,
  horizontal_straight_line: ih,
  horizontal_ray_line: rh,
  horizontal_segment: ch,
  vertical_straight_line: lh,
  vertical_ray_line: _h,
  vertical_segment: dh,
  straight_line: uh,
  ray_line: $h,
  segment: gh,
  arrow: hh,
  price_line: mh,
  price_channel_line: ph,
  parallel_straight_line: fh,
  fibonacci_line: yh,
  fibonacci_segment: Ch,
  fibonacci_circle: bh,
  fibonacci_spiral: vh,
  fibonacci_speed_resistance_fan: Lh,
  fibonacci_extension: xh,
  gann_box: wh,
  rect: kh,
  parallelogram: Ah,
  circle: Th,
  triangle: Mh,
  three_waves: Sh,
  five_waves: Dh,
  eight_waves: Ih,
  any_waves: Bh,
  abcd: Uh,
  xabcd: Ph,
  weak_magnet: zh,
  strong_magnet: Rh,
  period: Nh,
  standard_deviation: Oh,
  candle_type: Eh,
  candle_solid: jh,
  candle_stroke: Fh,
  candle_up_stroke: Kh,
  candle_down_stroke: Vh,
  ohlc: Qh,
  area: Zh,
  last_price_show: Hh,
  high_price_show: Yh,
  low_price_show: Gh,
  indicator_last_value_show: Jh,
  price_axis_type: Xh,
  normal: Wh,
  percentage: qh,
  log: em,
  reverse_coordinate: tm,
  grid_show: nm,
  restore_default: om,
  symbol_search: am,
  symbol_code: sm
}, rm = "Indicatore", cm = "Indicatore principale", lm = "Sottoindicatore", _m = "Impostazione", dm = "Fuso orario", um = "Schermata", $m = "Schermo intero", gm = "Esci", hm = "Salva", mm = "Conferma", pm = "Annulla", fm = "MA(Media mobile)", ym = "EMA (media mobile esponenziale)", Cm = "SMA", bm = "BOLL(Bolinger Bands)", vm = "BBI (Bull And Bearlndex)", Lm = "SAR(Stop and Reverse)", xm = "VOL(Volume)", wm = "MACD (convergenza media mobile / divergenza)", km = "KDJ(Indice KDJ)", Am = "RSI (Indice di forza relativa)", Tm = "BIAS(rapporto Bias)", Mm = "BRAR (Indicatore di Sentimento)", Sm = "CCI (Commodity Channel Index)", Dm = "DMI (indice di movimento direzionale)", Im = "CR (indicatore energetico)", Bm = "PSY(linea psicologica)", Um = "DMA (diverso dalla media mobile)", Pm = "TRIX (media mobile Triple Esponentially Smoothed)", zm = "OBV (Volume in equilibrio)", Rm = "VR (rapporto volume di volatilità)", Nm = "WR(Williams%R)", Om = "MTM(Indice Momentum)", Em = "EMV (valore di facilità di movimento)", jm = "ROC (tasso di variazione dei prezzi)", Fm = "PVT (andamento dei prezzi e del volume)", Km = "AO (fantastico oscillatore)", Vm = "UTC", Qm = "(UTC-10) Honolulu", Zm = "(UTC-8) Juneau", Hm = "(UTC-7) Los Angeles", Ym = "(UTC-5) Chicago", Gm = "(UTC-4) Toronto", Jm = "(UTC-3) San Paolo", Xm = "(UTC+1) Londra", Wm = "(UTC+2) Berlino", qm = "(UTC+3) Bahrain", ep = "(UTC+4) Dubai", tp = "(UTC+5) Ashkhabad", np = "(UTC+6) Almaty", op = "(UTC+7) Bangkok", ap = "(UTC+8) Shanghai", sp = "(UTC+9) Tokyo", ip = "(UTC+10) Sydney", rp = "(UTC+12) Norfolk", cp = "Linea orizzontale", lp = "Raggio orizzontale", _p = "Segmento orizzontale", dp = "Linea verticale", up = "Raggio verticale", $p = "Segmento verticale", gp = "Linea di tendenza", hp = "Ray", mp = "Segmento", pp = "Freccia", fp = "Linea di prezzo", yp = "Prezzo Linea canale", Cp = "Linea parallela", bp = "Linea Fibonacci", vp = "Segmento Fibonacci", Lp = "Cerchio di Fibonacci", xp = "Spirale Fibonacci", wp = "Settore Fibonacci", kp = "Estensione Fibonacci", Ap = "Gann Box", Tp = "Rett", Mp = "Parallelogramma", Sp = "Cerchio", Dp = "Triangolo", Ip = "Tre onde", Bp = "Cinque onde", Up = "Otto onde", Pp = "Qualsiasi onda", zp = "Modello ABCD", Rp = "Modello XABCD", Np = "Magnete debole", Op = "Magnete forte", Ep = "Periodo", jp = "Deviazione standard", Fp = "Tipo candelabro", Kp = "Solido", Vp = "Vuoto", Qp = "Rising Hollow", Zp = "Falling Hollow", Hp = "OHLC", Yp = "Area", Gp = "Mostra ultimo prezzo", Jp = "Visualizzazione dei prezzi alti", Xp = "Visualizzazione dei prezzi bassi", Wp = "Visualizzazione dell'ultimo valore dell'indicatore", qp = "Tipo di asse prezzo", ef = "Asse lineare", tf = "Asse percentuale", nf = "Asse logaritmico", of = "Coordinate invertite", af = "Visualizzazione linea griglia", sf = "Ripristina predefinito", rf = "Ricerca prodotto", cf = "Codice prodotto", lf = {
  indicator: rm,
  main_indicator: cm,
  sub_indicator: lm,
  setting: _m,
  timezone: dm,
  screenshot: um,
  full_screen: $m,
  exit_full_screen: gm,
  save: hm,
  confirm: mm,
  cancel: pm,
  ma: fm,
  ema: ym,
  sma: Cm,
  boll: bm,
  bbi: vm,
  sar: Lm,
  vol: xm,
  macd: wm,
  kdj: km,
  rsi: Am,
  bias: Tm,
  brar: Mm,
  cci: Sm,
  dmi: Dm,
  cr: Im,
  psy: Bm,
  dma: Um,
  trix: Pm,
  obv: zm,
  vr: Rm,
  wr: Nm,
  mtm: Om,
  emv: Em,
  roc: jm,
  pvt: Fm,
  ao: Km,
  utc: Vm,
  honolulu: Qm,
  juneau: Zm,
  los_angeles: Hm,
  chicago: Ym,
  toronto: Gm,
  sao_paulo: Jm,
  london: Xm,
  berlin: Wm,
  bahrain: qm,
  dubai: ep,
  ashkhabad: tp,
  almaty: np,
  bangkok: op,
  shanghai: ap,
  tokyo: sp,
  sydney: ip,
  norfolk: rp,
  horizontal_straight_line: cp,
  horizontal_ray_line: lp,
  horizontal_segment: _p,
  vertical_straight_line: dp,
  vertical_ray_line: up,
  vertical_segment: $p,
  straight_line: gp,
  ray_line: hp,
  segment: mp,
  arrow: pp,
  price_line: fp,
  price_channel_line: yp,
  parallel_straight_line: Cp,
  fibonacci_line: bp,
  fibonacci_segment: vp,
  fibonacci_circle: Lp,
  fibonacci_spiral: xp,
  fibonacci_speed_resistance_fan: wp,
  fibonacci_extension: kp,
  gann_box: Ap,
  rect: Tp,
  parallelogram: Mp,
  circle: Sp,
  triangle: Dp,
  three_waves: Ip,
  five_waves: Bp,
  eight_waves: Up,
  any_waves: Pp,
  abcd: zp,
  xabcd: Rp,
  weak_magnet: Np,
  strong_magnet: Op,
  period: Ep,
  standard_deviation: jp,
  candle_type: Fp,
  candle_solid: Kp,
  candle_stroke: Vp,
  candle_up_stroke: Qp,
  candle_down_stroke: Zp,
  ohlc: Hp,
  area: Yp,
  last_price_show: Gp,
  high_price_show: Jp,
  low_price_show: Xp,
  indicator_last_value_show: Wp,
  price_axis_type: qp,
  normal: ef,
  percentage: tf,
  log: nf,
  reverse_coordinate: of,
  grid_show: af,
  restore_default: sf,
  symbol_search: rf,
  symbol_code: cf
}, _f = "しじしんごう", df = "マスタインジケータ", uf = "サブメトリック", $f = "背景", gf = "タイムゾーン", hf = "スクリーンショット", mf = "全画面表示", pf = "アウトレット", ff = "に救援物資を送る", yf = "かくにん", Cf = "キャンセル", bf = "移動平均線", vf = "指数移動平均線", Lf = "スマ", xf = "ボリング帯", wf = "牛熊指数", kf = "SAR（駐車とバック）", Af = "VOL（音量）", Tf = "MACD（移動平均線収束／発散）", Mf = "KDJ（KDJ指数）", Sf = "相対強度指数", Df = "バイアス比", If = "情緒指標", Bf = "商品チャネル指数", Uf = "指向性運動指数", Pf = "CR（エネルギーインジケータ）", zf = "しんせん", Rf = "DMA（移動平均線とは異なる）", Nf = "三指数平滑移動平均線", Of = "OBV（バランス取引量）", Ef = "VR（変動量比率）", jf = "WR（ウィリアムズ%R）", Ff = "MTM（運動量指数）", Kf = "移動しやすい価値", Vf = "ROC（価格変化率）", Qf = "PVT（価格と数量トレンド）", Zf = "AO（素晴らしい発振器）", Hf = "クラッチ", Yf = "（UTC-10）ホノルル", Gf = "（UTC-8）ジュノー", Jf = "（UTC-7）ロサンゼルス", Xf = "（UTC-5）シカゴ", Wf = "（UTC-4）トロント", qf = "（UTC-3）サンパウロ", ey = "（UTC+1）ロンドン", ty = "（UTC+2）ベルリン", ny = "（UTC+3）バーレーン", oy = "（UTC+4）ドバイ", ay = "（UTC+5）アシュハバード", sy = "（UTC+6）アラームチャート", iy = "（UTC+7）バンコク", ry = "（UTC+8）上海", cy = "（UTC+9）東京", ly = "（UTC+10）シドニー", _y = "（UTC+12）ノーフォーク", dy = "水平線", uy = "すいへいせん", $y = "水平セグメント", gy = "垂直線", hy = "すいちょくせん", my = "垂直セグメント", py = "トレンド線", fy = "放射線", yy = "セグメント", Cy = "矢", by = "価格ライン", vy = "価格チャネルライン", Ly = "へいこうせん", xy = "フィボナッチ線", wy = "フィボナッチ区間", ky = "フィボナッチ円", Ay = "フィボナッチらせん", Ty = "フィボナッチセクタ", My = "フィボナッチ拡張", Sy = "Gannボックス", Dy = "Rect社", Iy = "平行四辺形", By = "サークル", Uy = "三角形", Py = "三波", zy = "ごは", Ry = "八つの波", Ny = "任意の波", Oy = "wen jianパターン", Ey = "XABCDモード", jy = "弱磁石", Fy = "強磁石", Ky = "の時刻を決める", Vy = "標準偏差", Qy = "キャンドルスティックタイプ", Zy = "ソリッド", Hy = "うつろ", Yy = "上昇する中空", Gy = "中空に墜落する.", Jy = "オーミックLC", Xy = "エリア", Wy = "最終価格表示", qy = "高価なディスプレイ", eC = "低価格ディスプレイ", tC = "インジケータの最後の値表示", nC = "価格軸タイプ", oC = "リニアシャフト", aC = "パーセンテージ軸", sC = "対数軸", iC = "逆座標", rC = "グリッド線表示", cC = "デフォルト値に戻す", lC = "製品検索", _C = "製品コード", dC = {
  indicator: _f,
  main_indicator: df,
  sub_indicator: uf,
  setting: $f,
  timezone: gf,
  screenshot: hf,
  full_screen: mf,
  exit_full_screen: pf,
  save: ff,
  confirm: yf,
  cancel: Cf,
  ma: bf,
  ema: vf,
  sma: Lf,
  boll: xf,
  bbi: wf,
  sar: kf,
  vol: Af,
  macd: Tf,
  kdj: Mf,
  rsi: Sf,
  bias: Df,
  brar: If,
  cci: Bf,
  dmi: Uf,
  cr: Pf,
  psy: zf,
  dma: Rf,
  trix: Nf,
  obv: Of,
  vr: Ef,
  wr: jf,
  mtm: Ff,
  emv: Kf,
  roc: Vf,
  pvt: Qf,
  ao: Zf,
  utc: Hf,
  honolulu: Yf,
  juneau: Gf,
  los_angeles: Jf,
  chicago: Xf,
  toronto: Wf,
  sao_paulo: qf,
  london: ey,
  berlin: ty,
  bahrain: ny,
  dubai: oy,
  ashkhabad: ay,
  almaty: sy,
  bangkok: iy,
  shanghai: ry,
  tokyo: cy,
  sydney: ly,
  norfolk: _y,
  horizontal_straight_line: dy,
  horizontal_ray_line: uy,
  horizontal_segment: $y,
  vertical_straight_line: gy,
  vertical_ray_line: hy,
  vertical_segment: my,
  straight_line: py,
  ray_line: fy,
  segment: yy,
  arrow: Cy,
  price_line: by,
  price_channel_line: vy,
  parallel_straight_line: Ly,
  fibonacci_line: xy,
  fibonacci_segment: wy,
  fibonacci_circle: ky,
  fibonacci_spiral: Ay,
  fibonacci_speed_resistance_fan: Ty,
  fibonacci_extension: My,
  gann_box: Sy,
  rect: Dy,
  parallelogram: Iy,
  circle: By,
  triangle: Uy,
  three_waves: Py,
  five_waves: zy,
  eight_waves: Ry,
  any_waves: Ny,
  abcd: Oy,
  xabcd: Ey,
  weak_magnet: jy,
  strong_magnet: Fy,
  period: Ky,
  standard_deviation: Vy,
  candle_type: Qy,
  candle_solid: Zy,
  candle_stroke: Hy,
  candle_up_stroke: Yy,
  candle_down_stroke: Gy,
  ohlc: Jy,
  area: Xy,
  last_price_show: Wy,
  high_price_show: qy,
  low_price_show: eC,
  indicator_last_value_show: tC,
  price_axis_type: nC,
  normal: oC,
  percentage: aC,
  log: sC,
  reverse_coordinate: iC,
  grid_show: rC,
  restore_default: cC,
  symbol_search: lC,
  symbol_code: _C
}, uC = "지시신호", $C = "주 표시기", gC = "하위 지표", hC = "배경", mC = "시간대", pC = "캡처", fC = "전체 화면 표시", yC = "출구", CC = "구원", bC = "확인", vC = "취소", LC = "평균선 이동", xC = "지수 이동 평균선", wC = "스마", kC = "볼링거 벨트", AC = "곰 지수", TC = "SAR(주차 및 후진)", MC = "VOL(볼륨)", SC = "MACD(이동평균선 수렴/발산)", DC = "KDJ (KDJ 지수)", IC = "상대 강도 지수", BC = "편향비", UC = "정서 지표", PC = "상품 채널 지수", zC = "방향 운동 지수", RC = "CR(에너지 표시기)", NC = "심리선", OC = "DMA(이동평균선과 다름)", EC = "삼지수 매끄러운 이동 평균선", jC = "OBV(거래량 균형)", FC = "VR(파동량 비율)", KC = "WR (윌리엄스%R)", VC = "MTM(운동량 지수)", QC = "이동성이 뛰어난 가치", ZC = "ROC(가격 변동률)", HC = "PVT(가격 및 수량 동향)", YC = "AO (굉장한 발진기)", GC = "클러치", JC = "(UTC-10) 호놀룰루", XC = "(UTC-8) 주노", WC = "(UTC-7) 로스앤젤레스", qC = "(UTC-5) 시카고", eb = "(UTC-4) 토론토", tb = "(UTC-3) 상파울루", nb = "(UTC+1) 런던", ob = "(UTC+2) 베를린", ab = "(UTC+3) 바레인", sb = "(UTC+4) 두바이", ib = "(UTC+5) 아슈하바트", rb = "(UTC+6) 알마티", cb = "(UTC+7) 방콕", lb = "(UTC+8) 상하이", _b = "(UTC+9) 도쿄", db = "(UTC+10) 시드니", ub = "(UTC+12) 노퍽", $b = "수평선", gb = "수평선", hb = "수평 세그먼트", mb = "수직선", pb = "수직선", fb = "수직선 세그먼트", yb = "추세선", Cb = "방사선", bb = "세그먼트", vb = "화살", Lb = "가격선", xb = "가격 채널 라인", wb = "평행선", kb = "피보나치 선", Ab = "피보나치 구간", Tb = "피보나치 원", Mb = "피보나치 나선", Sb = "피보나치 섹터", Db = "피보나치 확장", Ib = "Gann 상자", Bb = "Rect 회사", Ub = "평행사변형", Pb = "원", zb = "삼각형", Rb = "삼파", Nb = "오파", Ob = "여덟 개의 파도", Eb = "모든 파도", jb = "wen jian 패턴", Fb = "XABCD 모드", Kb = "약자석", Vb = "강한 자석", Qb = "시기", Zb = "표준 편차", Hb = "초봉 유형", Yb = "고체", Gb = "공허했어", Jb = "상승의 공심", Xb = "공중으로 떨어지다", Wb = "옴 LC", qb = "지역", ev = "마지막 가격 표시", tv = "고가의 모니터", nv = "저가 모니터", ov = "표시기 마지막 값 표시", av = "가격 축 유형", sv = "선형 축", iv = "백분율 축", rv = "대수축", cv = "좌표 대칭 이동", lv = "메쉬 선 디스플레이", _v = "기본값 복원", dv = "제품 검색", uv = "제품 코드", $v = {
  indicator: uC,
  main_indicator: $C,
  sub_indicator: gC,
  setting: hC,
  timezone: mC,
  screenshot: pC,
  full_screen: fC,
  exit_full_screen: yC,
  save: CC,
  confirm: bC,
  cancel: vC,
  ma: LC,
  ema: xC,
  sma: wC,
  boll: kC,
  bbi: AC,
  sar: TC,
  vol: MC,
  macd: SC,
  kdj: DC,
  rsi: IC,
  bias: BC,
  brar: UC,
  cci: PC,
  dmi: zC,
  cr: RC,
  psy: NC,
  dma: OC,
  trix: EC,
  obv: jC,
  vr: FC,
  wr: KC,
  mtm: VC,
  emv: QC,
  roc: ZC,
  pvt: HC,
  ao: YC,
  utc: GC,
  honolulu: JC,
  juneau: XC,
  los_angeles: WC,
  chicago: qC,
  toronto: eb,
  sao_paulo: tb,
  london: nb,
  berlin: ob,
  bahrain: ab,
  dubai: sb,
  ashkhabad: ib,
  almaty: rb,
  bangkok: cb,
  shanghai: lb,
  tokyo: _b,
  sydney: db,
  norfolk: ub,
  horizontal_straight_line: $b,
  horizontal_ray_line: gb,
  horizontal_segment: hb,
  vertical_straight_line: mb,
  vertical_ray_line: pb,
  vertical_segment: fb,
  straight_line: yb,
  ray_line: Cb,
  segment: bb,
  arrow: vb,
  price_line: Lb,
  price_channel_line: xb,
  parallel_straight_line: wb,
  fibonacci_line: kb,
  fibonacci_segment: Ab,
  fibonacci_circle: Tb,
  fibonacci_spiral: Mb,
  fibonacci_speed_resistance_fan: Sb,
  fibonacci_extension: Db,
  gann_box: Ib,
  rect: Bb,
  parallelogram: Ub,
  circle: Pb,
  triangle: zb,
  three_waves: Rb,
  five_waves: Nb,
  eight_waves: Ob,
  any_waves: Eb,
  abcd: jb,
  xabcd: Fb,
  weak_magnet: Kb,
  strong_magnet: Vb,
  period: Qb,
  standard_deviation: Zb,
  candle_type: Hb,
  candle_solid: Yb,
  candle_stroke: Gb,
  candle_up_stroke: Jb,
  candle_down_stroke: Xb,
  ohlc: Wb,
  area: qb,
  last_price_show: ev,
  high_price_show: tv,
  low_price_show: nv,
  indicator_last_value_show: ov,
  price_axis_type: av,
  normal: sv,
  percentage: iv,
  log: rv,
  reverse_coordinate: cv,
  grid_show: lv,
  restore_default: _v,
  symbol_search: dv,
  symbol_code: uv
}, gv = "Indicador", hv = "Indicador Principal", mv = "Subindicador", pv = "Configuração", fv = "Fuso horário", yv = "Captura de Ecrã", Cv = "Ecrã Completo", bv = "Sair", vv = "Gravar", Lv = "Confirmar", xv = "Cancelar", wv = "MA (Média Móvel)", kv = "EMA( Média Móvel Exponencial)", Av = "SMA", Tv = "BOLL( Faixas de Bolinger)", Mv = "BBI (Bull And Bearlndex)", Sv = "SAR( Parar e Reverter)", Dv = "VOL( Volume)", Iv = "MACD (Convergência/Divergência Média Móvel)", Bv = "KDJ( Índice KDJ)", Uv = "RSI( Índice de Força Relativa)", Pv = "BIAS( Razão de Bias)", zv = "BRAR (Indicador de Sentimentos)", Rv = "CCI( Commodity Channel Index)", Nv = "DMI (Índice de Movimento Direcional)", Ov = "CR (Indicador energético)", Ev = "PSY( Linha Psicológica)", jv = "DMA( Diferente da Média Móvel)", Fv = "TRIX (Média Móvel Tripla Exponentemente Suavizada)", Kv = "OBV( On Balance Volume)", Vv = "VR( Volatilidade Volume Ratio)", Qv = "WR( Williams%R)", Zv = "MTM( Índice Momentum)", Hv = "EMV( Valor de Facilidade de Movimento)", Yv = "ROC( Taxa de variação de preços)", Gv = "PVT (Tendência de preços e volume)", Jv = "AO( Oscilador Awesome)", Xv = "UTC", Wv = "(UTC- 10) Honolulu", qv = "(UTC- 8) Juneau", eL = "(UTC- 7) Los Angeles", tL = "(UTC- 5) Chicago", nL = "(UTC- 4) Toronto", oL = "(UTC- 3) Sao Paulo", aL = "(UTC+1) Londres", sL = "(UTC+2) Berlim", iL = "(UTC+3) Bahrein", rL = "(UTC+4) Dubai", cL = "(UTC+5) Ashkhabad", lL = "(UTC+6) Almaty", _L = "(UTC+7) Banguecoque", dL = "(UTC+8) Xangai", uL = "(UTC+9) Tóquio", $L = "(UTC+10) Sydney", gL = "(UTC+12) Norfolk", hL = "Linha Horizontal", mL = "Raio Horizontal", pL = "Segmento Horizontal", fL = "Linha Vertical", yL = "Raio Vertical", CL = "Segmento Vertical", bL = "Linha de Tendência", vL = "Ray", LL = "Segmento", xL = "Seta", wL = "Linha de Preços", kL = "Linha de Canais de Preços", AL = "Linha Paralela", TL = "Linha Fibonacci", ML = "Segmento Fibonacci", SL = "Círculo de Fibonacci", DL = "Espiral de Fibonacci", IL = "Sector Fibonacci", BL = "Extensão Fibonacci", UL = "Caixa Gann", PL = "Recto", zL = "Paralelograma", RL = "Círculo", NL = "Triângulo", OL = "Três Ondas", EL = "Cinco Ondas", jL = "Oito Ondas", FL = "Qualquer Onda", KL = "Padrão ABCD", VL = "Padrão XABCD", QL = "Ímã Fraco", ZL = "Ímã Forte", HL = "Período", YL = "Desvio Padrão", GL = "Tipo Candlestick", JL = "Sólido", XL = "Oco", WL = "Rising Hollow", qL = "Falling Hollow", ex = "OHLC", tx = "Área", nx = "Mostrar o Último Preço", ox = "Exibição do Preço Elevado", ax = "Exibição do Preço Baixo", sx = "Indicador Último Valor Exibição", ix = "Tipo de eixo de preço", rx = "Eixo Linear", cx = "Eixo Percentagem", lx = "Eixo Logarítmico", _x = "Coordenadas Invertidas", dx = "Apresentação da Linha da Grade", ux = "Restaurar o Predefinição", $x = "Pesquisa de Produtos", gx = "Código do produto", hx = {
  indicator: gv,
  main_indicator: hv,
  sub_indicator: mv,
  setting: pv,
  timezone: fv,
  screenshot: yv,
  full_screen: Cv,
  exit_full_screen: bv,
  save: vv,
  confirm: Lv,
  cancel: xv,
  ma: wv,
  ema: kv,
  sma: Av,
  boll: Tv,
  bbi: Mv,
  sar: Sv,
  vol: Dv,
  macd: Iv,
  kdj: Bv,
  rsi: Uv,
  bias: Pv,
  brar: zv,
  cci: Rv,
  dmi: Nv,
  cr: Ov,
  psy: Ev,
  dma: jv,
  trix: Fv,
  obv: Kv,
  vr: Vv,
  wr: Qv,
  mtm: Zv,
  emv: Hv,
  roc: Yv,
  pvt: Gv,
  ao: Jv,
  utc: Xv,
  honolulu: Wv,
  juneau: qv,
  los_angeles: eL,
  chicago: tL,
  toronto: nL,
  sao_paulo: oL,
  london: aL,
  berlin: sL,
  bahrain: iL,
  dubai: rL,
  ashkhabad: cL,
  almaty: lL,
  bangkok: _L,
  shanghai: dL,
  tokyo: uL,
  sydney: $L,
  norfolk: gL,
  horizontal_straight_line: hL,
  horizontal_ray_line: mL,
  horizontal_segment: pL,
  vertical_straight_line: fL,
  vertical_ray_line: yL,
  vertical_segment: CL,
  straight_line: bL,
  ray_line: vL,
  segment: LL,
  arrow: xL,
  price_line: wL,
  price_channel_line: kL,
  parallel_straight_line: AL,
  fibonacci_line: TL,
  fibonacci_segment: ML,
  fibonacci_circle: SL,
  fibonacci_spiral: DL,
  fibonacci_speed_resistance_fan: IL,
  fibonacci_extension: BL,
  gann_box: UL,
  rect: PL,
  parallelogram: zL,
  circle: RL,
  triangle: NL,
  three_waves: OL,
  five_waves: EL,
  eight_waves: jL,
  any_waves: FL,
  abcd: KL,
  xabcd: VL,
  weak_magnet: QL,
  strong_magnet: ZL,
  period: HL,
  standard_deviation: YL,
  candle_type: GL,
  candle_solid: JL,
  candle_stroke: XL,
  candle_up_stroke: WL,
  candle_down_stroke: qL,
  ohlc: ex,
  area: tx,
  last_price_show: nx,
  high_price_show: ox,
  low_price_show: ax,
  indicator_last_value_show: sx,
  price_axis_type: ix,
  normal: rx,
  percentage: cx,
  log: lx,
  reverse_coordinate: _x,
  grid_show: dx,
  restore_default: ux,
  symbol_search: $x,
  symbol_code: gx
}, mx = "индикаторный сигнал", px = "Главный индикатор", fx = "Подиндикатор", yx = "Справочная информация", Cx = "Часовой пояс", bx = "Снимок экрана", vx = "Полный экран", Lx = "Экспорт", xx = "Спасение", wx = "Подтверждение", kx = "Отменить", Ax = "Переместить среднюю", Tx = "Индекс скользящей средней", Mx = "Сма.", Sx = "полоса Полингера", Dx = "Индекс коровьего медведя", Ix = "SAR (парковка и задний ход)", Bx = "Vol (Громкость)", Ux = "MACD (сходимость / расход скользящей средней)", Px = "KDJ (Индекс KDJ)", zx = "Индекс относительной прочности", Rx = "Коэффициент смещения", Nx = "Эмоциональные показатели", Ox = "Индекс товарных каналов", Ex = "индекс направленного движения", jx = "CR (индикатор энергии)", Fx = "Психологическая линия", Kx = "DMA (в отличие от скользящей средней)", Vx = "Трехэкспоненциальная скользящая средняя", Qx = "OBV (сбалансированный объем транзакций)", Zx = "VR (Коэффициент волатильности)", Hx = "WR (Williams% R)", Yx = "MTM (Индекс импульса)", Gx = "Перемещаемая стоимость", Jx = "ROC (Коэффициент изменения цен)", Xx = "ПВТ (ценовые и количественные тенденции)", Wx = "AO (Потрясающий генератор)", qx = "Сцепление", ew = "(UTC - 10) Гонолулу", tw = "(UTC - 8) Джуно", nw = "(UTC - 7) Лос - Анджелес", ow = "(UTC - 5) Чикаго", aw = "(UTC - 4) Торонто", sw = "(UTC - 3) Сан - Паулу", iw = "(UTC + 1) Лондон", rw = "(UTC + 2) Берлин", cw = "(UTC + 3) Бахрейн", lw = "(UTC + 4) Дубай", _w = "(UTC + 5) Ашхабад", dw = "(UTC + 6) Алматы", uw = "(UTC + 7) Бангкок", $w = "(UTC + 8) Шанхай", gw = "(UTC + 9) Токио", hw = "(UTC + 10) Сидней", mw = "(UTC + 12) Норфолк", pw = "Горизонтальная линия", fw = "Горизонтальные лучи", yw = "Горизонтальный сегмент", Cw = "Вертикальная линия", bw = "Вертикальные лучи", vw = "Вертикальный отрезок", Lw = "Линия тренда", xw = "Луч", ww = "Пункт", kw = "Стрела", Aw = "Линия цен", Tw = "Линия ценовых каналов", Mw = "Параллельные линии", Sw = "линия Фибоначчи", Dw = "участок Фибоначчи", Iw = "окружность Фибоначчи", Bw = "спираль Фибоначчи", Uw = "Сектор Фибоначчи", Pw = "Расширение Фибоначчи", zw = "Кассет Gann", Rw = "Компания Rect", Nw = "Параллельный четырёхугольник", Ow = "Круг", Ew = "Треугольник", jw = "Три волны", Fw = "Пять волн.", Kw = "Восемь волн.", Vw = "Любые волны", Qw = "Изображения Wen Jian", Zw = "Режим XABCD", Hw = "Слабый магнит", Yw = "Сильный магнит", Gw = "Период", Jw = "Стандартное отклонение", Xw = "Типы свечей", Ww = "Твердые тела", qw = "Пустой", ek = "Поднимающаяся пустота", tk = "Упал в пустоту.", nk = "Ом LC", ok = "Регион", ak = "Предыдущая цена Показать", sk = "Высококачественный монитор", ik = "Дешевый монитор", rk = "Показать последнее значение индикатора", ck = "Тип ценовой оси", lk = "Линейная ось", _k = "Процентная ось", dk = "Парачисловая ось", uk = "Обратные координаты", $k = "Показать строку сетки", gk = "Восстановление значения по умолчанию", hk = "Поиск продукции", mk = "Код продукта", pk = {
  indicator: mx,
  main_indicator: px,
  sub_indicator: fx,
  setting: yx,
  timezone: Cx,
  screenshot: bx,
  full_screen: vx,
  exit_full_screen: Lx,
  save: xx,
  confirm: wx,
  cancel: kx,
  ma: Ax,
  ema: Tx,
  sma: Mx,
  boll: Sx,
  bbi: Dx,
  sar: Ix,
  vol: Bx,
  macd: Ux,
  kdj: Px,
  rsi: zx,
  bias: Rx,
  brar: Nx,
  cci: Ox,
  dmi: Ex,
  cr: jx,
  psy: Fx,
  dma: Kx,
  trix: Vx,
  obv: Qx,
  vr: Zx,
  wr: Hx,
  mtm: Yx,
  emv: Gx,
  roc: Jx,
  pvt: Xx,
  ao: Wx,
  utc: qx,
  honolulu: ew,
  juneau: tw,
  los_angeles: nw,
  chicago: ow,
  toronto: aw,
  sao_paulo: sw,
  london: iw,
  berlin: rw,
  bahrain: cw,
  dubai: lw,
  ashkhabad: _w,
  almaty: dw,
  bangkok: uw,
  shanghai: $w,
  tokyo: gw,
  sydney: hw,
  norfolk: mw,
  horizontal_straight_line: pw,
  horizontal_ray_line: fw,
  horizontal_segment: yw,
  vertical_straight_line: Cw,
  vertical_ray_line: bw,
  vertical_segment: vw,
  straight_line: Lw,
  ray_line: xw,
  segment: ww,
  arrow: kw,
  price_line: Aw,
  price_channel_line: Tw,
  parallel_straight_line: Mw,
  fibonacci_line: Sw,
  fibonacci_segment: Dw,
  fibonacci_circle: Iw,
  fibonacci_spiral: Bw,
  fibonacci_speed_resistance_fan: Uw,
  fibonacci_extension: Pw,
  gann_box: zw,
  rect: Rw,
  parallelogram: Nw,
  circle: Ow,
  triangle: Ew,
  three_waves: jw,
  five_waves: Fw,
  eight_waves: Kw,
  any_waves: Vw,
  abcd: Qw,
  xabcd: Zw,
  weak_magnet: Hw,
  strong_magnet: Yw,
  period: Gw,
  standard_deviation: Jw,
  candle_type: Xw,
  candle_solid: Ww,
  candle_stroke: qw,
  candle_up_stroke: ek,
  candle_down_stroke: tk,
  ohlc: nk,
  area: ok,
  last_price_show: ak,
  high_price_show: sk,
  low_price_show: ik,
  indicator_last_value_show: rk,
  price_axis_type: ck,
  normal: lk,
  percentage: _k,
  log: dk,
  reverse_coordinate: uk,
  grid_show: $k,
  restore_default: gk,
  symbol_search: hk,
  symbol_code: mk
}, fk = "สัญญาณบ่งชี้", yk = "ตัวบ่งชี้หลัก", Ck = "ตัวชี้วัดย่อย", bk = "พื้นหลัง", vk = "โซนเวลา", Lk = "ภาพหน้าจอ", xk = "จอแสดงผลแบบเต็มหน้าจอ", wk = "ทางออก", kk = "ความรอด", Ak = "ยืนยัน", Tk = "การยกเลิก", Mk = "ค่าเฉลี่ยเคลื่อนที่", Sk = "ค่าเฉลี่ยเคลื่อนที่แบบเอ็กซ์โพเนนเชียล", Dk = "สมา", Ik = "เข็มขัด Pollinger", Bk = "ดัชนีวัวและหมี", Uk = "SAR (ที่จอดรถและถอยหลัง)", Pk = "VOL (ปริมาณ)", zk = "MACD (ค่าเฉลี่ยเคลื่อนที่บรรจบ/ไดเวอร์เจนซ์)", Rk = "KDJ (ดัชนี KDJ)", Nk = "ดัชนีความแข็งแรงสัมพัทธ์", Ok = "อัตราส่วนอคติ", Ek = "ตัวบ่งชี้อารมณ์", jk = "ดัชนีช่องทางสินค้าโภคภัณฑ์", Fk = "ดัชนีการเคลื่อนไหวทิศทาง", Kk = "CR (ตัวบ่งชี้พลังงาน)", Vk = "เส้นจิตวิทยา", Qk = "DMA (แตกต่างจากค่าเฉลี่ยเคลื่อนที่)", Zk = "ค่าเฉลี่ยเคลื่อนที่เรียบสามดัชนี", Hk = "OBV (ปริมาณการซื้อขายที่สมดุล)", Yk = "VR (อัตราส่วนความผันผวนของปริมาณ)", Gk = "WR (วิลเลียม% R)", Jk = "MTM (ดัชนีโมเมนตัม)", Xk = "มูลค่าการเคลื่อนย้ายง่าย", Wk = "ROC (อัตราการเปลี่ยนแปลงของราคา)", qk = "PVT (แนวโน้มราคาและปริมาณ)", eA = "AO (ออสซิลเลเตอร์ที่ยอดเยี่ยม)", tA = "คลัตช์", nA = "(UTC-10) โฮโนลูลู", oA = "(UTC-8) จูโน", aA = "(UTC-7) ลอสแองเจลิส", sA = "(UTC-5) ชิคาโก", iA = "(UTC-4)โตรอนโต", rA = "(UTC-3) เซาเปาโล", cA = "(UTC+1) ลอนดอน", lA = "(UTC+2) เบอร์ลิน", _A = "(UTC+3) บาห์เรน", dA = "(UTC+4) ดูไบ", uA = "(UTC+5) แอชกาบัด", $A = "(UTC+6) อัลมาตี", gA = "(UTC+7) กรุงเทพฯ", hA = "(UTC+8) เซี่ยงไฮ้", mA = "(UTC+9) โตเกียว", pA = "(UTC+10) ซิดนีย์", fA = "(UTC+12) นอร์ฟอล์ก", yA = "เส้นแนวนอน", CA = "รังสีแนวนอน", bA = "กลุ่มแนวนอน", vA = "เส้นแนวตั้ง", LA = "เรย์แนวตั้ง", xA = "ส่วนเส้นแนวตั้ง", wA = "เส้นแนวโน้ม", kA = "เรย์", AA = "ส่วน", TA = "ลูกศร", MA = "เส้นราคา", SA = "ช่องราคา Line", DA = "เส้นขนาน", IA = "สาย Fibonacci", BA = "ส่วน Fibonacci", UA = "วงกลม Fibonacci", PA = "Fibonacci เกลียว", zA = "ภาค Fibonacci", RA = "ส่วนขยาย Fibonacci", NA = "กล่อง Gann", OA = "บริษัท Rect", EA = "สี่เหลี่ยมด้านขนาน", jA = "วงกลม", FA = "สามเหลี่ยม", KA = "สามคลื่น", VA = "ห้าคลื่น", QA = "แปดคลื่น", ZA = "คลื่นใด ๆ", HA = "รูปแบบเวินเจียน", YA = "โหมด XABCD", GA = "แม่เหล็กที่อ่อนแอ", JA = "แม่เหล็กที่แข็งแกร่ง", XA = "ระยะเวลา", WA = "ส่วนเบี่ยงเบนมาตรฐาน", qA = "ประเภทเทียนแท่ง", eT = "ของแข็ง", tT = "กลวง", nT = "กลวงที่เพิ่มขึ้น", oT = "ตกกลวง", aT = "โอห์ม LC", sT = "ภูมิภาค", iT = "แสดงราคาล่าสุด", rT = "จอแสดงผลราคาสูง", cT = "จอแสดงผลราคาต่ำ", lT = "ตัวบ่งชี้ แสดงค่าสุดท้าย", _T = "ประเภทเพลาราคา", dT = "เพลาเชิงเส้น", uT = "เปอร์เซ็นต์เพลา", $T = "แกนคู่", gT = "พิกัดย้อนกลับ", hT = "จอแสดงผล Gridline", mT = "เรียกคืนค่าปริยาย", pT = "ค้นหาผลิตภัณฑ์", fT = "รหัสสินค้า", yT = {
  indicator: fk,
  main_indicator: yk,
  sub_indicator: Ck,
  setting: bk,
  timezone: vk,
  screenshot: Lk,
  full_screen: xk,
  exit_full_screen: wk,
  save: kk,
  confirm: Ak,
  cancel: Tk,
  ma: Mk,
  ema: Sk,
  sma: Dk,
  boll: Ik,
  bbi: Bk,
  sar: Uk,
  vol: Pk,
  macd: zk,
  kdj: Rk,
  rsi: Nk,
  bias: Ok,
  brar: Ek,
  cci: jk,
  dmi: Fk,
  cr: Kk,
  psy: Vk,
  dma: Qk,
  trix: Zk,
  obv: Hk,
  vr: Yk,
  wr: Gk,
  mtm: Jk,
  emv: Xk,
  roc: Wk,
  pvt: qk,
  ao: eA,
  utc: tA,
  honolulu: nA,
  juneau: oA,
  los_angeles: aA,
  chicago: sA,
  toronto: iA,
  sao_paulo: rA,
  london: cA,
  berlin: lA,
  bahrain: _A,
  dubai: dA,
  ashkhabad: uA,
  almaty: $A,
  bangkok: gA,
  shanghai: hA,
  tokyo: mA,
  sydney: pA,
  norfolk: fA,
  horizontal_straight_line: yA,
  horizontal_ray_line: CA,
  horizontal_segment: bA,
  vertical_straight_line: vA,
  vertical_ray_line: LA,
  vertical_segment: xA,
  straight_line: wA,
  ray_line: kA,
  segment: AA,
  arrow: TA,
  price_line: MA,
  price_channel_line: SA,
  parallel_straight_line: DA,
  fibonacci_line: IA,
  fibonacci_segment: BA,
  fibonacci_circle: UA,
  fibonacci_spiral: PA,
  fibonacci_speed_resistance_fan: zA,
  fibonacci_extension: RA,
  gann_box: NA,
  rect: OA,
  parallelogram: EA,
  circle: jA,
  triangle: FA,
  three_waves: KA,
  five_waves: VA,
  eight_waves: QA,
  any_waves: ZA,
  abcd: HA,
  xabcd: YA,
  weak_magnet: GA,
  strong_magnet: JA,
  period: XA,
  standard_deviation: WA,
  candle_type: qA,
  candle_solid: eT,
  candle_stroke: tT,
  candle_up_stroke: nT,
  candle_down_stroke: oT,
  ohlc: aT,
  area: sT,
  last_price_show: iT,
  high_price_show: rT,
  low_price_show: cT,
  indicator_last_value_show: lT,
  price_axis_type: _T,
  normal: dT,
  percentage: uT,
  log: $T,
  reverse_coordinate: gT,
  grid_show: hT,
  restore_default: mT,
  symbol_search: pT,
  symbol_code: fT
}, CT = "Tín hiệu chỉ thị", bT = "Chỉ số chính", vT = "Chỉ số con", LT = "Nền", xT = "Múi giờ", wT = "Ảnh chụp màn hình", kT = "Hiển thị toàn màn hình", AT = "Xuất khẩu", TT = "Giải cứu", MT = "Xác nhận", ST = "Hủy bỏ", DT = "Đường trung bình động", IT = "Đường trung bình động Index", BT = "Trang chủ", UT = "Vành đai Paulinger", PT = "Chỉ số gấu bò", zT = "SAR (Dừng xe và lùi xe)", RT = "vol (âm lượng)", NT = "MACD (Moving Average Convergence/Divergence) là gì?", OT = "KDJ (Chỉ số KDJ)", ET = "Chỉ số sức mạnh tương đối", jT = "Tỷ lệ bù đắp", FT = "Chỉ số cảm xúc", KT = "Chỉ số kênh hàng hóa", VT = "Chỉ số chuyển động định hướng", QT = "CR (Chỉ số năng lượng)", ZT = "Dòng tâm lý", HT = "DMA (khác với đường trung bình động)", YT = "Triple Index Smooth Đường trung bình động", GT = "OBV (Cân bằng khối lượng giao dịch)", JT = "VR (tỷ lệ biến động)", XT = "WR (tỷ lệ% R)", WT = "MTM (Chỉ số động lượng)", qT = "Dễ dàng di chuyển giá trị", eM = "ROC (Tỷ lệ thay đổi giá)", tM = "PVT (xu hướng giá và khối lượng)", nM = "AO (bộ dao động tuyệt vời)", oM = "Ly hợp", aM = "(UTC-10) Thành phố Honolulu", sM = "(UTC-8) tại Juno", iM = "(UTC-7) tại Los Angeles", rM = "(UTC-5) tại Chicago", cM = "(UTC-4) tại Toronto", lM = "(UTC-3) Sao Paulo", _M = "(UTC+1) Luân Đôn", dM = "(UTC+2) tại Berlin", uM = "(UTC+3) Bahrain", $M = "(UTC+4) tại Dubai", gM = "(UTC+5) Ashgabat", hM = "(UTC+6) tại Almaty", mM = "(UTC+7) tại Bangkok", pM = "(UTC+8) Thượng Hải", fM = "(UTC+9) tại Tokyo", yM = "(UTC+10) tại Sydney", CM = "(UTC+12) tại Norfolk", bM = "Đường ngang", vM = "Ray ngang", LM = "Phân đoạn ngang", xM = "Đường thẳng đứng", wM = "Tia dọc", kM = "Đoạn thẳng đứng", AM = "Đường xu hướng", TM = "Tia", MM = "Phân đoạn", SM = "Mũi tên", DM = "Dòng giá", IM = "Đường kênh giá", BM = "Đường song song", UM = "Đường Fibonacci", PM = "Phân đoạn Fibonacci", zM = "Vòng tròn Fibonacci", RM = "Fibonacci xoắn ốc", NM = "Khu vực Fibonacci", OM = "Fibonacci mở rộng", EM = "Hộp Gann", jM = "Công ty Rect", FM = "Tứ giác song song", KM = "Vòng tròn", VM = "Tam giác", QM = "Ba làn sóng", ZM = "Năm làn sóng", HM = "8 Sóng", YM = "Bất kỳ sóng", GM = "Mô hình wen jian", JM = "Mô hình XACD", XM = "Magnet yếu", WM = "Nam châm mạnh", qM = "Thời kỳ", eS = "Độ lệch chuẩn", tS = "Loại Candle Stick", nS = "Rắn", oS = "Trống rỗng", aS = "Lời bài hát: Hollow On The Rise", sS = "Rơi rỗng", iS = "bởi ohm LC", rS = "Quận", cS = "Giá cuối cùng hiển thị", lS = "Màn hình giá cao", _S = "Màn hình giá thấp", dS = "Chỉ số Hiển thị giá trị cuối cùng", uS = "Loại trục giá", $S = "Trục tuyến tính", gS = "Phần trăm trục", hS = "Đối với trục số", mS = "Tọa độ ngược", pS = "Hiển thị đường lưới", fS = "Khôi phục mặc định", yS = "Tìm kiếm sản phẩm", CS = "Mã sản phẩm", bS = {
  indicator: CT,
  main_indicator: bT,
  sub_indicator: vT,
  setting: LT,
  timezone: xT,
  screenshot: wT,
  full_screen: kT,
  exit_full_screen: AT,
  save: TT,
  confirm: MT,
  cancel: ST,
  ma: DT,
  ema: IT,
  sma: BT,
  boll: UT,
  bbi: PT,
  sar: zT,
  vol: RT,
  macd: NT,
  kdj: OT,
  rsi: ET,
  bias: jT,
  brar: FT,
  cci: KT,
  dmi: VT,
  cr: QT,
  psy: ZT,
  dma: HT,
  trix: YT,
  obv: GT,
  vr: JT,
  wr: XT,
  mtm: WT,
  emv: qT,
  roc: eM,
  pvt: tM,
  ao: nM,
  utc: oM,
  honolulu: aM,
  juneau: sM,
  los_angeles: iM,
  chicago: rM,
  toronto: cM,
  sao_paulo: lM,
  london: _M,
  berlin: dM,
  bahrain: uM,
  dubai: $M,
  ashkhabad: gM,
  almaty: hM,
  bangkok: mM,
  shanghai: pM,
  tokyo: fM,
  sydney: yM,
  norfolk: CM,
  horizontal_straight_line: bM,
  horizontal_ray_line: vM,
  horizontal_segment: LM,
  vertical_straight_line: xM,
  vertical_ray_line: wM,
  vertical_segment: kM,
  straight_line: AM,
  ray_line: TM,
  segment: MM,
  arrow: SM,
  price_line: DM,
  price_channel_line: IM,
  parallel_straight_line: BM,
  fibonacci_line: UM,
  fibonacci_segment: PM,
  fibonacci_circle: zM,
  fibonacci_spiral: RM,
  fibonacci_speed_resistance_fan: NM,
  fibonacci_extension: OM,
  gann_box: EM,
  rect: jM,
  parallelogram: FM,
  circle: KM,
  triangle: VM,
  three_waves: QM,
  five_waves: ZM,
  eight_waves: HM,
  any_waves: YM,
  abcd: GM,
  xabcd: JM,
  weak_magnet: XM,
  strong_magnet: WM,
  period: qM,
  standard_deviation: eS,
  candle_type: tS,
  candle_solid: nS,
  candle_stroke: oS,
  candle_up_stroke: aS,
  candle_down_stroke: sS,
  ohlc: iS,
  area: rS,
  last_price_show: cS,
  high_price_show: lS,
  low_price_show: _S,
  indicator_last_value_show: dS,
  price_axis_type: uS,
  normal: $S,
  percentage: gS,
  log: hS,
  reverse_coordinate: mS,
  grid_show: pS,
  restore_default: fS,
  symbol_search: yS,
  symbol_code: CS
}, vS = "指標", LS = "主圖指標", xS = "副圖指標", wS = "設置", kS = "時區", AS = "截屏", TS = "全屏", MS = "退出全屏", SS = "保存", DS = "確定", IS = "取消", BS = "MA(移動平均線)", US = "EMA(指數平滑移動平均線)", PS = "SMA", zS = "BOLL(布林線)", RS = "BBI(多空指數)", NS = "SAR(停損點指向指標)", OS = "VOL(成交量)", ES = "MACD(指數平滑異同移動平均線)", jS = "KDJ(隨機指標)", FS = "RSI(相對強弱指標)", KS = "BIAS(乖離率)", VS = "BRAR(情緒指標)", QS = "CCI(順勢指標)", ZS = "DMI(動向指標)", HS = "CR(能量指標)", YS = "PSY(心理線)", GS = "DMA(平行線差指標)", JS = "TRIX(三重指數平滑平均線)", XS = "OBV(能量潮指標)", WS = "VR(成交量變異率)", qS = "WR(威廉指標)", eD = "MTM(動量指標)", tD = "EMV(簡易波動指標)", nD = "ROC(變動率指標)", oD = "PVT(價量趨勢指標)", aD = "AO(動量震盪指標)", sD = "世界統一時間", iD = "(UTC-10) 檀香山", rD = "(UTC-8) 朱諾", cD = "(UTC-7) 洛杉磯", lD = "(UTC-5) 芝加哥", _D = "(UTC-4) 多倫多", dD = "(UTC-3) 聖保羅", uD = "(UTC+1) 倫敦", $D = "(UTC+2) 柏林", gD = "(UTC+3) 巴林", hD = "(UTC+4) 迪拜", mD = "(UTC+5) 阿什哈巴德", pD = "(UTC+6) 阿拉木圖", fD = "(UTC+7) 曼谷", yD = "(UTC+8) 上海", CD = "(UTC+9) 東京", bD = "(UTC+10) 悉尼", vD = "(UTC+12) 諾福克島", LD = "水平直線", xD = "水平射線", wD = "水平線段", kD = "垂直直線", AD = "垂直射線", TD = "垂直線段", MD = "直線", SD = "射線", DD = "線段", ID = "箭頭", BD = "價格線", UD = "價格通道線", PD = "平行直線", zD = "斐波那契回調直線", RD = "斐波那契回調線段", ND = "斐波那契圓環", OD = "斐波那契螺旋", ED = "斐波那契速度阻力扇", jD = "斐波那契趨勢擴展", FD = "江恩箱", KD = "矩形", VD = "平行四邊形", QD = "圓", ZD = "三角形", HD = "三浪", YD = "五浪", GD = "八浪", JD = "任意浪", XD = "ABCD形態", WD = "XABCD形態", qD = "弱磁模式", eI = "強磁模式", tI = "商品搜索", nI = "商品代碼", oI = "參數1", aI = "參數2", sI = "參數3", iI = "參數4", rI = "參數5", cI = "週期", lI = "標準差", _I = "蠟燭圖類型", dI = "全實心", uI = "全空心", $I = "漲空心", gI = "跌空心", hI = "OHLC", mI = "面積圖", pI = "最新價顯示", fI = "最高價顯示", yI = "最低價顯示", CI = "指標最新值顯示", bI = "價格軸類型", vI = "線性軸", LI = "百分比軸", xI = "對數軸", wI = "倒置坐標", kI = "網格線顯示", AI = "恢復默認", TI = {
  indicator: vS,
  main_indicator: LS,
  sub_indicator: xS,
  setting: wS,
  timezone: kS,
  screenshot: AS,
  full_screen: TS,
  exit_full_screen: MS,
  save: SS,
  confirm: DS,
  cancel: IS,
  ma: BS,
  ema: US,
  sma: PS,
  boll: zS,
  bbi: RS,
  sar: NS,
  vol: OS,
  macd: ES,
  kdj: jS,
  rsi: FS,
  bias: KS,
  brar: VS,
  cci: QS,
  dmi: ZS,
  cr: HS,
  psy: YS,
  dma: GS,
  trix: JS,
  obv: XS,
  vr: WS,
  wr: qS,
  mtm: eD,
  emv: tD,
  roc: nD,
  pvt: oD,
  ao: aD,
  utc: sD,
  honolulu: iD,
  juneau: rD,
  los_angeles: cD,
  chicago: lD,
  toronto: _D,
  sao_paulo: dD,
  london: uD,
  berlin: $D,
  bahrain: gD,
  dubai: hD,
  ashkhabad: mD,
  almaty: pD,
  bangkok: fD,
  shanghai: yD,
  tokyo: CD,
  sydney: bD,
  norfolk: vD,
  horizontal_straight_line: LD,
  horizontal_ray_line: xD,
  horizontal_segment: wD,
  vertical_straight_line: kD,
  vertical_ray_line: AD,
  vertical_segment: TD,
  straight_line: MD,
  ray_line: SD,
  segment: DD,
  arrow: ID,
  price_line: BD,
  price_channel_line: UD,
  parallel_straight_line: PD,
  fibonacci_line: zD,
  fibonacci_segment: RD,
  fibonacci_circle: ND,
  fibonacci_spiral: OD,
  fibonacci_speed_resistance_fan: ED,
  fibonacci_extension: jD,
  gann_box: FD,
  rect: KD,
  parallelogram: VD,
  circle: QD,
  triangle: ZD,
  three_waves: HD,
  five_waves: YD,
  eight_waves: GD,
  any_waves: JD,
  abcd: XD,
  xabcd: WD,
  weak_magnet: qD,
  strong_magnet: eI,
  symbol_search: tI,
  symbol_code: nI,
  params_1: oI,
  params_2: aI,
  params_3: sI,
  params_4: iI,
  params_5: rI,
  period: cI,
  standard_deviation: lI,
  candle_type: _I,
  candle_solid: dI,
  candle_stroke: uI,
  candle_up_stroke: $I,
  candle_down_stroke: gI,
  ohlc: hI,
  area: mI,
  last_price_show: pI,
  high_price_show: fI,
  low_price_show: yI,
  indicator_last_value_show: CI,
  price_axis_type: bI,
  normal: vI,
  percentage: LI,
  log: xI,
  reverse_coordinate: wI,
  grid_show: kI,
  restore_default: AI
}, cn = {
  "zh-CN": J8,
  "en-US": W7,
  "ar-AR": e_,
  "de-DE": nu,
  "es-ES": ag,
  "fr-FR": im,
  "it-IT": lf,
  "ko-KR": $v,
  "ja-JP": dC,
  "pt-BR": hx,
  "ru-RU": pk,
  "th-TH": yT,
  "vi-VN": bS,
  "zh-HK": TI,
  "my-My": W7
};
function TU(e, t) {
  cn[e] = t;
}
const _ = (e, t) => {
  var n;
  return ((n = cn[t]) == null ? void 0 : n[e]) ?? e;
}, MI = /* @__PURE__ */ g('<div class="klinecharts-pro-period-bar"><div class="item tools"><span></span></div><div class="item tools"><svg viewBox="0 0 20 20" fill="#76808F"><path d="M19.7361,12.542L18.1916,11.2919C18.2647,10.8678,18.3025,10.4347,18.3025,10.0017C18.3025,9.56861,18.2647,9.13555,18.1916,8.71142L19.7361,7.46135C19.9743,7.26938,20.0615,6.95686,19.9554,6.6756L19.9342,6.61756C19.5074,5.49026,18.8755,4.45449,18.0549,3.53926L18.0124,3.49238C17.8096,3.26692,17.4819,3.1821,17.1848,3.28032L15.2677,3.92544C14.5603,3.3763,13.7704,2.94324,12.9168,2.63966L12.5466,0.742229C12.49,0.449802,12.2472,0.222111,11.9383,0.168536L11.8746,0.157375C10.6461,-0.0524583,9.35391,-0.0524583,8.1254,0.157375L8.06174,0.168536C7.75284,0.222111,7.50997,0.449802,7.45338,0.742229L7.08082,2.64859C6.2343,2.95217,5.44909,3.383,4.74641,3.92991L2.81522,3.28032C2.52047,3.1821,2.19036,3.26469,1.98757,3.49238L1.94513,3.53926C1.12455,4.45672,0.492609,5.49249,0.0658141,6.61756L0.0445921,6.6756C-0.0615171,6.95463,0.0257283,7.26715,0.263885,7.46135L1.82723,8.72482C1.75413,9.14448,1.71876,9.57308,1.71876,9.99944C1.71876,10.428,1.75413,10.8566,1.82723,11.2741L0.263885,12.5375C0.025729,12.7295,-0.0615164,13.042,0.0445929,13.3233L0.0658148,13.3813C0.49261,14.5064,1.12455,15.5444,1.94513,16.4596L1.98757,16.5065C2.19036,16.732,2.51812,16.8168,2.81522,16.7186L4.74641,16.069C5.44909,16.6159,6.2343,17.0489,7.08082,17.3503L7.45338,19.2567C7.50997,19.5491,7.75284,19.7768,8.06174,19.8303L8.1254,19.8415C8.74084,19.9464,9.37042,20,10,20C10.6296,20,11.2615,19.9464,11.8746,19.8415L11.9383,19.8303C12.2472,19.7768,12.49,19.5491,12.5466,19.2567L12.9168,17.3592C13.7704,17.0556,14.5603,16.6248,15.2677,16.0734L17.1848,16.7186C17.4795,16.8168,17.8096,16.7342,18.0124,16.5065L18.0549,16.4596C18.8755,15.5422,19.5074,14.5064,19.9342,13.3813L19.9554,13.3233C20.0615,13.0487,19.9743,12.7362,19.7361,12.542ZM16.5175,8.97483C16.5764,9.3119,16.6071,9.65791,16.6071,10.0039C16.6071,10.3499,16.5764,10.6959,16.5175,11.033L16.3618,11.9281L18.1233,13.3545C17.8568,13.9372,17.5196,14.4863,17.1188,14.9975L14.9305,14.2631L14.1901,14.839C13.6266,15.2765,12.9994,15.6203,12.3203,15.8614L11.4219,16.1806L10.9998,18.3459C10.3372,18.4173,9.66045,18.4173,8.9955,18.3459L8.57342,16.1761L7.6821,15.8524C7.01008,15.6114,6.38521,15.2676,5.82637,14.8323L5.08596,14.2541L2.88361,14.9953C2.48275,14.4841,2.14791,13.9327,1.8791,13.3523L3.65938,11.9125L3.50611,11.0196C3.44952,10.687,3.41887,10.3432,3.41887,10.0039C3.41887,9.66237,3.44716,9.32083,3.50611,8.98822L3.65938,8.09531L1.8791,6.6555C2.14556,6.07288,2.48275,5.52374,2.88361,5.01255L5.08596,5.75367L5.82637,5.17551C6.38521,4.74022,7.01008,4.39645,7.6821,4.15536L8.57578,3.83615L8.99786,1.66638C9.66045,1.59495,10.3372,1.59495,11.0021,1.66638L11.4242,3.83168L12.3226,4.1509C12.9994,4.39198,13.6289,4.73575,14.1925,5.17328L14.9329,5.7492L17.1211,5.01479C17.522,5.52598,17.8568,6.07734,18.1256,6.65773L16.3642,8.08416L16.5175,8.97483ZM10.0024,5.85189C7.7104,5.85189,5.85231,7.61092,5.85231,9.78068C5.85231,11.9504,7.7104,13.7095,10.0024,13.7095C12.2943,13.7095,14.1524,11.9504,14.1524,9.78068C14.1524,7.61092,12.2943,5.85189,10.0024,5.85189ZM11.8699,11.5486C11.37,12.0196,10.7074,12.2808,10.0024,12.2808C9.29732,12.2808,8.63473,12.0196,8.13483,11.5486C7.6373,11.0754,7.36142,10.4481,7.36142,9.78068C7.36142,9.11323,7.6373,8.48596,8.13483,8.01272C8.63473,7.53948,9.29732,7.28054,10.0024,7.28054C10.7074,7.28054,11.37,7.53948,11.8699,8.01272C12.3674,8.48596,12.6433,9.11323,12.6433,9.78068C12.6433,10.4481,12.3674,11.0754,11.8699,11.5486Z"></path></svg></div><div class="item tools"><svg viewBox="0 0 20 20" fill="#76808F"><path d="M6.50977,1L13.4902,1C13.6406,1,13.7695,1.1104910000000001,13.7969,1.2631700000000001L14.0273,2.52277C14.1387,3.13147,14.6543,3.57143,15.2559,3.57143L17.5,3.57143C18.8809,3.57143,20,4.72254,20,6.14286L20,16.4286C20,17.8489,18.8809,19,17.5,19L2.5,19C1.11914,19,0,17.8489,0,16.4286L0,6.14286C0,4.72254,1.11914,3.57143,2.5,3.57143L4.74414,3.57143C5.3457,3.57143,5.86133,3.13147,5.97266,2.52277L6.20312,1.2631700000000001C6.23047,1.1104910000000001,6.35937,1,6.50977,1ZM15.2559,4.857139999999999C14.0547,4.857139999999999,13.0215,3.97522,12.7988,2.75982L12.7129,2.28571L7.28711,2.28571L7.20117,2.75982C6.98047,3.97522,5.94727,4.857139999999999,4.74414,4.857139999999999L2.5,4.857139999999999C1.81055,4.857139999999999,1.25,5.43371,1.25,6.14286L1.25,16.4286C1.25,17.1377,1.81055,17.7143,2.5,17.7143L17.5,17.7143C18.1895,17.7143,18.75,17.1377,18.75,16.4286L18.75,6.14286C18.75,5.43371,18.1895,4.857139999999999,17.5,4.857139999999999L15.2559,4.857139999999999ZM4.375,6.78571L3.125,6.78571C2.7793,6.78571,2.5,6.49844,2.5,6.14286C2.5,5.78728,2.7793,5.5,3.125,5.5L4.375,5.5C4.7207,5.5,5,5.78728,5,6.14286C5,6.49844,4.7207,6.78571,4.375,6.78571ZM10,6.14286C7.06641,6.14286,4.6875,8.58973,4.6875,11.6071C4.6875,14.6246,7.06641,17.0714,10,17.0714C12.9336,17.0714,15.3125,14.6246,15.3125,11.6071C15.3125,8.58973,12.9336,6.14286,10,6.14286ZM10,7.42857C11.0859,7.42857,12.1055,7.8625,12.873,8.65201C13.6406,9.44152,14.0625,10.49018,14.0625,11.6071C14.0625,12.7241,13.6406,13.7728,12.873,14.5623C12.1055,15.3518,11.0859,15.7857,10,15.7857C8.91406,15.7857,7.89453,15.3518,7.12695,14.5623C6.35937,13.7728,5.9375,12.7241,5.9375,11.6071C5.9375,10.49018,6.35938,9.44152,7.12695,8.65201C7.89453,7.8625,8.91406,7.42857,10,7.42857ZM10,9.67857C8.96484,9.67857,8.125,10.54241,8.125,11.6071C8.125,12.6719,8.96484,13.5357,10,13.5357C11.0352,13.5357,11.875,12.6719,11.875,11.6071C11.875,10.54241,11.0352,9.67857,10,9.67857ZM10,10.96429C10.3438,10.96429,10.625,11.2536,10.625,11.6071C10.625,11.9607,10.3438,12.25,10,12.25C9.65625,12.25,9.375,11.9607,9.375,11.6071C9.375,11.2536,9.65625,10.96429,10,10.96429Z"></path></svg></div></div>'), SI = /* @__PURE__ */ g("<span></span>"), DI = (e) => {
  const [t, n] = C(!1), o = () => {
    n((a) => !a);
  };
  return Tt(() => {
    document.addEventListener("fullscreenchange", o), document.addEventListener("mozfullscreenchange", o), document.addEventListener("webkitfullscreenchange", o), document.addEventListener("msfullscreenchange", o);
  }), w1(() => {
    document.removeEventListener("fullscreenchange", o), document.removeEventListener("mozfullscreenchange", o), document.removeEventListener("webkitfullscreenchange", o), document.removeEventListener("msfullscreenchange", o);
  }), (() => {
    const a = MI.cloneNode(!0), s = a.firstChild, r = s.firstChild, i = s.nextSibling, c = i.nextSibling;
    return A1(($) => {
    }, a), p(a, () => e.periods.map(($) => (() => {
      const l = SI.cloneNode(!0);
      return l.$$click = () => {
        e.onPeriodChange($);
      }, p(l, () => $.text), O(() => re(l, `item period ${$.text === e.period.text ? "selected" : ""}`)), l;
    })()), s), Be(s, "click", e.onIndicatorClick, !0), p(r, () => _("indicator", e.locale)), Be(i, "click", e.onSettingClick, !0), Be(c, "click", e.onScreenshotClick, !0), a;
  })();
};
Z(["click"]);
const II = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M12.41465,11L18.5,11C18.7761,11,19,11.22386,19,11.5C19,11.77614,18.7761,12,18.5,12L12.41465,12C12.20873,12.5826,11.65311,13,11,13C10.34689,13,9.79127,12.5826,9.58535,12L3.5,12C3.223857,12,3,11.77614,3,11.5C3,11.22386,3.223857,11,3.5,11L9.58535,11C9.79127,10.417404,10.34689,10,11,10C11.65311,10,12.20873,10.417404,12.41465,11Z" stroke-opacity="0" stroke="none"></path></svg>'), BI = () => II.cloneNode(!0), UI = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M6.91465,11L11.08535,11C11.29127,10.417404,11.84689,10,12.5,10C13.15311,10,13.70873,10.417404,13.91465,11L18.5,11C18.7761,11,19,11.22386,19,11.5C19,11.77614,18.7761,12,18.5,12L13.91465,12C13.70873,12.5826,13.15311,13,12.5,13C11.84689,13,11.29127,12.5826,11.08535,12L6.91465,12C6.70873,12.5826,6.15311,13,5.5,13C4.671573,13,4,12.32843,4,11.5C4,10.671573,4.671573,10,5.5,10C6.15311,10,6.70873,10.417404,6.91465,11Z" stroke-opacity="0" stroke="none"></path></svg>'), PI = () => UI.cloneNode(!0), zI = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M6.91465,12.5C6.70873,13.0826,6.15311,13.5,5.5,13.5C4.671573,13.5,4,12.82843,4,12C4,11.171573,4.671573,10.5,5.5,10.5C6.15311,10.5,6.70873,10.917404,6.91465,11.5L16.0853,11.5C16.2913,10.917404,16.846899999999998,10.5,17.5,10.5C18.328400000000002,10.5,19,11.171573,19,12C19,12.82843,18.328400000000002,13.5,17.5,13.5C16.846899999999998,13.5,16.2913,13.0826,16.0853,12.5L6.91465,12.5Z" stroke-opacity="0" stroke="none"></path></svg>'), RI = () => zI.cloneNode(!0), NI = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M11,12.41465L11,18.5C11,18.7761,11.22386,19,11.5,19C11.77614,19,12,18.7761,12,18.5L12,12.41465C12.5826,12.20873,13,11.65311,13,11C13,10.34689,12.5826,9.79127,12,9.58535L12,3.5C12,3.223857,11.77614,3,11.5,3C11.22386,3,11,3.223857,11,3.5L11,9.58535C10.417404,9.79127,10,10.34689,10,11C10,11.65311,10.417404,12.20873,11,12.41465Z" stroke-opacity="0" stroke="none"></path></svg>'), OI = () => NI.cloneNode(!0), EI = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M11.66558837890625,19C10.83716137890625,19,10.16558837890625,18.328400000000002,10.16558837890625,17.5C10.16558837890625,16.846899999999998,10.58298437890625,16.2913,11.16557337890625,16.0854L11.16557337890625,11.91464C10.58298437890625,11.70872,10.16558837890625,11.1531,10.16558837890625,10.5C10.16558837890625,9.8469,10.58298437890625,9.29128,11.16557337890625,9.08536L11.16557337890625,4.5C11.16557337890625,4.223857,11.38942837890625,4,11.66556837890625,4C11.94171837890625,4,12.16556837890625,4.223857,12.16556837890625,4.5L12.16556837890625,9.08535C12.74817837890625,9.291260000000001,13.16558837890625,9.846879999999999,13.16558837890625,10.5C13.16558837890625,11.153120000000001,12.74817837890625,11.708739999999999,12.16556837890625,11.91465L12.16556837890625,16.0854C12.74817837890625,16.2913,13.16558837890625,16.846899999999998,13.16558837890625,17.5C13.16558837890625,18.328400000000002,12.49401837890625,19,11.66558837890625,19Z" stroke-opacity="0" stroke="none"></path></svg>'), jI = () => EI.cloneNode(!0), FI = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M11.165603637695312,6.91465C11.748203637695312,6.70873,12.165603637695312,6.15311,12.165603637695312,5.5C12.165603637695312,4.671573,11.494033637695313,4,10.665603637695312,4C9.837176637695313,4,9.165603637695312,4.671573,9.165603637695312,5.5C9.165603637695312,6.15311,9.583007637695312,6.70873,10.165603637695312,6.91465L10.165603637695312,16.0854C9.583007637695312,16.2913,9.165603637695312,16.846899999999998,9.165603637695312,17.5C9.165603637695312,18.328400000000002,9.837176637695313,19,10.665603637695312,19C11.494033637695313,19,12.165603637695312,18.328400000000002,12.165603637695312,17.5C12.165603637695312,16.846899999999998,11.748203637695312,16.2913,11.165603637695312,16.0854L11.165603637695312,6.91465Z" stroke-opacity="0" fill-rule="evenodd" fill-opacity="1"></path></svg>'), KI = () => FI.cloneNode(!0), VI = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M5.146447,15.753C4.9511845,15.9483,4.9511845,16.2649,5.146447,16.4602C5.341709,16.6554,5.658291,16.6554,5.853554,16.4602L8.156600000000001,14.15711C8.352409999999999,14.25082,8.57173,14.3033,8.8033,14.3033C9.631730000000001,14.3033,10.3033,13.63172,10.3033,12.80329C10.3033,12.57172,10.250820000000001,12.352409999999999,10.157119999999999,12.15659L12.156600000000001,10.15711C12.352409999999999,10.250820000000001,12.571729999999999,10.30329,12.8033,10.30329C13.63173,10.30329,14.3033,9.63172,14.3033,8.80329C14.3033,8.57172,14.25082,8.352409999999999,14.15712,8.15659L16.4602,5.853553C16.6554,5.658291,16.6554,5.341709,16.4602,5.146447C16.2649,4.9511843,15.9483,4.9511843,15.753,5.146447L13.45001,7.449479999999999C13.25419,7.35577,13.03487,7.3032900000000005,12.8033,7.3032900000000005C11.97487,7.3032900000000005,11.3033,7.97487,11.3033,8.80329C11.3033,9.03487,11.35578,9.254190000000001,11.44949,9.450009999999999L9.450009999999999,11.449480000000001C9.254190000000001,11.35577,9.03487,11.30329,8.8033,11.30329C7.97487,11.30329,7.3033,11.97487,7.3033,12.80329C7.3033,13.03487,7.35578,13.25419,7.44949,13.45001L5.146447,15.753Z" stroke-opacity="0" stroke="none"></path></svg>'), QI = () => VI.cloneNode(!0), ZI = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M7.573332939453125,14.54567903564453C7.667042939453125,14.741499035644532,7.719512939453125,14.960809035644532,7.719512939453125,15.19239903564453C7.719512939453125,16.02079903564453,7.047942939453125,16.69239903564453,6.219512939453125,16.69239903564453C5.391085939453125,16.69239903564453,4.719512939453125,16.02079903564453,4.719512939453125,15.19239903564453C4.719512939453125,14.36394903564453,5.391085939453125,13.692379035644532,6.219512939453125,13.692379035644532C6.451092939453125,13.692379035644532,6.670412939453125,13.74485903564453,6.866232939453125,13.83856903564453L9.865702939453126,10.83909903564453C9.771992939453124,10.643279035644532,9.719512939453125,10.42395903564453,9.719512939453125,10.192379035644532C9.719512939453125,9.36394903564453,10.391082939453124,8.692379035644532,11.219512939453125,8.692379035644532C11.451092939453126,8.692379035644532,11.670412939453126,8.74485903564453,11.866232939453125,8.838569035644532L15.462112939453124,5.242645035644531C15.657412939453126,5.047383335644532,15.974012939453125,5.047383335644532,16.169212939453125,5.242645035644531C16.364512939453125,5.437907035644531,16.364512939453125,5.754489035644531,16.169212939453125,5.949752035644531L12.573332939453124,9.545679035644532C12.667042939453125,9.74149903564453,12.719512939453125,9.96080903564453,12.719512939453125,10.192379035644532C12.719512939453125,11.020809035644533,12.047942939453126,11.692379035644532,11.219512939453125,11.692379035644532C10.987942939453125,11.692379035644532,10.768632939453125,11.639909035644532,10.572812939453126,11.54619903564453L7.573332939453125,14.54567903564453Z" stroke-opacity="0" stroke="none"></path></svg>'), HI = () => ZI.cloneNode(!0), YI = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M15.719512939453125,8.461776733398438C16.547912939453127,8.461776733398438,17.219512939453125,7.7902067333984375,17.219512939453125,6.9617767333984375C17.219512939453125,6.133349733398438,16.547912939453127,5.4617767333984375,15.719512939453125,5.4617767333984375C14.891082939453124,5.4617767333984375,14.219512939453125,6.133349733398438,14.219512939453125,6.9617767333984375C14.219512939453125,7.193346733398437,14.271992939453124,7.412666733398438,14.365692939453124,7.608486733398438L7.366222939453126,14.607956733398437C7.170402939453125,14.514256733398437,6.951082939453125,14.461776733398438,6.719512939453125,14.461776733398438C5.891085939453125,14.461776733398438,5.219512939453125,15.133346733398437,5.219512939453125,15.961776733398438C5.219512939453125,16.79017673339844,5.891085939453125,17.461776733398438,6.719512939453125,17.461776733398438C7.547942939453125,17.461776733398438,8.219512939453125,16.79017673339844,8.219512939453125,15.961776733398438C8.219512939453125,15.730176733398437,8.167032939453126,15.510876733398437,8.073322939453124,15.315066733398437L15.072802939453124,8.315586733398437C15.268612939453124,8.409296733398438,15.487912939453125,8.461776733398438,15.719512939453125,8.461776733398438Z" stroke-opacity="0" stroke="none"></path></svg>'), GI = () => YI.cloneNode(!0), JI = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M17.0643,7.033864912109375L18,3.585784912109375L14.5078,4.509695912109375L15.3537,5.344934912109375L6.02026,14.560584912109375C5.87635,14.517484912109374,5.72366,14.494284912109375,5.5655,14.494284912109375C4.7009,14.494284912109375,4,15.186384912109375,4,16.040084912109375C4,16.893784912109375,4.7009,17.585784912109375,5.5655,17.585784912109375C6.43011,17.585784912109375,7.13101,16.893784912109375,7.13101,16.040084912109375C7.13101,15.722284912109375,7.03392,15.426984912109376,6.86744,15.181384912109374L16.0917,6.073604912109375L17.0643,7.033864912109375Z" stroke-opacity="0" stroke="none"></path></svg>'), XI = () => JI.cloneNode(!0), WI = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M6.91465,13.00505L18.5,13.00505C18.7761,13.00505,19,13.228909999999999,19,13.50505C19,13.781189999999999,18.7761,14.00505,18.5,14.00505L6.91465,14.00505C6.70873,14.58765,6.15311,15.00505,5.5,15.00505C4.671573,15.00505,4,14.33348,4,13.50505C4,12.67662,4.671573,12.00505,5.5,12.00505C6.15311,12.00505,6.70873,12.422450000000001,6.91465,13.00505ZM7.81404,11.625L10.48591,11.625L10.48591,10.90625L9.65193,10.90625L9.65193,7.125L8.997630000000001,7.125C8.71443,7.306641,8.415600000000001,7.419922,7.96443,7.498047L7.96443,8.05078L8.77497,8.05078L8.77497,10.90625L7.81404,10.90625L7.81404,11.625ZM11.081620000000001,11.625L14.0562,11.625L14.0562,10.88281L13.09724,10.88281C12.8863,10.88281,12.59333,10.90625,12.36482,10.93555C13.17537,10.11328,13.84724,9.2207,13.84724,8.39062C13.84724,7.541016,13.28865,7,12.4488,7C11.84333,7,11.446850000000001,7.234375,11.03279,7.679688L11.52497,8.16797C11.747630000000001,7.914062,12.0113,7.697266,12.33552,7.697266C12.7613,7.697266,13.00154,7.982422,13.00154,8.43359C13.00154,9.14648,12.29255,10.00781,11.081620000000001,11.11523L11.081620000000001,11.625ZM15.9605,11.75C16.8121,11.75,17.526899999999998,11.2832,17.526899999999998,10.4375C17.526899999999998,9.82031,17.142200000000003,9.43945,16.6441,9.30078L16.6441,9.27148C17.1129,9.08594,17.3824,8.7207,17.3824,8.21289C17.3824,7.421875,16.8004,7,15.9429,7C15.4215,7,14.9957,7.210938,14.6109,7.541016L15.066,8.11133C15.3258,7.849609,15.5836,7.697266,15.9019,7.697266C16.2789,7.697266,16.4957,7.914062,16.4957,8.28125C16.4957,8.70898,16.2301,9,15.4215,9L15.4215,9.63672C16.3804,9.63672,16.6383,9.91992,16.6383,10.38086C16.6383,10.79688,16.3336,11.03125,15.8824,11.03125C15.4742,11.03125,15.1578,10.82227,14.8922,10.55078L14.4781,11.13281C14.7906,11.486329999999999,15.2652,11.75,15.9605,11.75Z" stroke-opacity="0" stroke="none"></path></svg>'), qI = () => WI.cloneNode(!0), eB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M3.146447,14.178126025390625C2.9511847,13.982826025390626,2.9511847,13.666226025390625,3.146447,13.470926025390625L7.39146,9.225966025390626C7.35417,9.095106025390624,7.33421,8.956946025390625,7.33421,8.814116025390625C7.33421,7.985696025390625,8.00578,7.314116025390625,8.834209999999999,7.314116025390625C8.97703,7.314116025390625,9.11519,7.334086025390625,9.24605,7.371366025390625L13.753,2.864373025390625C13.9483,2.669110325390625,14.2649,2.669110325390625,14.4602,2.864373025390625C14.6554,3.059635025390625,14.6554,3.376217025390625,14.4602,3.571479025390625L10.06916,7.962476025390625C10.23631,8.204386025390626,10.334209999999999,8.497826025390625,10.334209999999999,8.814116025390625C10.334209999999999,9.642546025390626,9.66264,10.314116025390625,8.834209999999999,10.314116025390625C8.51791,10.314116025390625,8.22448,10.216226025390625,7.98256,10.049076025390626L3.853554,14.178126025390625C3.658291,14.373326025390625,3.341709,14.373326025390625,3.146447,14.178126025390625ZM7.67736,19.188526025390626C7.4821,18.993226025390626,7.4821,18.676626025390625,7.67736,18.481426025390626L9.9804,16.178326025390625C9.88669,15.982526025390625,9.834209999999999,15.763226025390624,9.834209999999999,15.531626025390626C9.834209999999999,14.703226025390626,10.50578,14.031626025390626,11.33421,14.031626025390626C11.56579,14.031626025390626,11.78511,14.084126025390624,11.98093,14.177826025390624L13.9804,12.178356025390626C13.8867,11.982536025390624,13.8342,11.763216025390625,13.8342,11.531636025390625C13.8342,10.703206025390624,14.5058,10.031636025390625,15.3342,10.031636025390625C15.5658,10.031636025390625,15.7851,10.084116025390625,15.9809,10.177826025390626L18.284,7.874796025390625C18.4792,7.679536025390625,18.7958,7.679536025390625,18.9911,7.874796025390625C19.1863,8.070056025390624,19.1863,8.386636025390626,18.9911,8.581906025390625L16.688000000000002,10.884936025390624C16.7817,11.080756025390626,16.8342,11.300066025390626,16.8342,11.531636025390625C16.8342,12.360066025390624,16.162599999999998,13.031626025390626,15.3342,13.031626025390626C15.1026,13.031626025390626,14.8833,12.979126025390626,14.6875,12.885426025390625L12.68803,14.884926025390625C12.78174,15.080726025390625,12.83421,15.300026025390626,12.83421,15.531626025390626C12.83421,16.360026025390624,12.16264,17.031626025390626,11.33421,17.031626025390626C11.10264,17.031626025390626,10.88333,16.979126025390627,10.68751,16.885426025390625L8.38446,19.188526025390626C8.1892,19.383726025390626,7.87262,19.383726025390626,7.67736,19.188526025390626Z" stroke-opacity="0" stroke="none"></path></svg>'), tB = () => eB.cloneNode(!0), nB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M3.3367688759765626,12.63173C3.5320318759765623,12.82699,3.8486138759765627,12.82699,4.043876875976562,12.63173L11.822052875976562,4.853553C12.017312875976563,4.658291,12.017312875976563,4.341708,11.822052875976562,4.146446C11.626792875976562,3.9511843,11.310202875976563,3.9511843,11.114942875976563,4.146446L3.3367688759765626,11.92462C3.1415071759765625,12.11988,3.1415071759765625,12.43647,3.3367688759765626,12.63173ZM5.001492875976562,17.0351C4.806232875976562,16.8399,4.806232875976562,16.5233,5.001492875976562,16.328L7.304532875976562,14.025C7.210822875976563,13.82916,7.158352875976563,13.60984,7.158352875976563,13.37827C7.158352875976563,12.54984,7.829922875976562,11.87827,8.658352875976561,11.87827C8.889922875976563,11.87827,9.109232875976563,11.93075,9.305052875976562,12.02446L11.304532875976562,10.02498C11.210822875976563,9.82916,11.158352875976561,9.60984,11.158352875976561,9.37827C11.158352875976561,8.54984,11.829922875976562,7.8782700000000006,12.658352875976563,7.8782700000000006C12.889922875976563,7.8782700000000006,13.109232875976563,7.93075,13.305022875976562,8.024460000000001L15.608122875976562,5.72142C15.803322875976562,5.5261499999999995,16.119922875976563,5.5261499999999995,16.315222875976563,5.72142C16.510422875976563,5.9166799999999995,16.510422875976563,6.23326,16.315222875976563,6.42852L14.012122875976562,8.73156C14.105822875976562,8.92738,14.158322875976562,9.1467,14.158322875976562,9.37827C14.158322875976562,10.2067,13.486822875976562,10.87827,12.658352875976563,10.87827C12.426772875976562,10.87827,12.207452875976562,10.82579,12.011642875976563,10.73209L10.012162875976562,12.73156C10.105872875976562,12.92738,10.158352875976561,13.1467,10.158352875976561,13.37827C10.158352875976561,14.2067,9.486772875976563,14.8783,8.658352875976561,14.8783C8.426772875976562,14.8783,8.207452875976562,14.8258,8.011642875976563,14.7321L5.708602875976562,17.0351C5.513342875976562,17.2304,5.196752875976562,17.2304,5.001492875976562,17.0351ZM10.415712875976563,18.328C10.220452875976562,18.5233,9.903862875976563,18.5233,9.708602875976563,18.328C9.513342875976562,18.1328,9.513342875976562,17.816200000000002,9.708602875976563,17.6209L12.304532875976562,15.025C12.210822875976563,14.8292,12.158352875976563,14.6098,12.158352875976563,14.3783C12.158352875976563,13.54984,12.829922875976562,12.87827,13.658322875976562,12.87827C13.889922875976563,12.87827,14.109222875976563,12.93075,14.305022875976562,13.02446L17.486822875976564,9.84274C17.682022875976564,9.64747,17.99862287597656,9.64747,18.19392287597656,9.84274C18.38912287597656,10.038,18.38912287597656,10.35458,18.19392287597656,10.54984L15.012122875976562,13.73156C15.105822875976562,13.92738,15.158322875976562,14.1467,15.158322875976562,14.3783C15.158322875976562,15.2067,14.486822875976562,15.8783,13.658322875976562,15.8783C13.426822875976562,15.8783,13.207422875976562,15.8258,13.011642875976563,15.7321L10.415712875976563,18.328Z" stroke-opacity="0" stroke="none"></path></svg>'), oB = () => nB.cloneNode(!0), aB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M13.1889,6C12.98303,6.582599999999999,12.42741,7,11.7743,7C11.12119,7,10.565570000000001,6.582599999999999,10.35965,6L3.5,6C3.223857,6,3,5.77614,3,5.5C3,5.22386,3.223857,5,3.5,5L10.35965,5C10.565570000000001,4.417404,11.12119,4,11.7743,4C12.42741,4,12.98303,4.417404,13.1889,5L18.5,5C18.7761,5,19,5.22386,19,5.5C19,5.77614,18.7761,6,18.5,6L13.1889,6ZM3,8.5C3,8.22386,3.223857,8,3.5,8L18.5,8C18.7761,8,19,8.22386,19,8.5C19,8.77614,18.7761,9,18.5,9L3.5,9C3.223857,9,3,8.77614,3,8.5ZM3.278549,11.5C3.278549,11.22386,3.502407,11,3.778549,11L18.7785,11C19.0547,11,19.2785,11.22386,19.2785,11.5C19.2785,11.77614,19.0547,12,18.7785,12L3.778549,12C3.502407,12,3.278549,11.77614,3.278549,11.5ZM3.139267,14.5C3.139267,14.2239,3.363124,14,3.6392670000000003,14L18.6393,14C18.915399999999998,14,19.1393,14.2239,19.1393,14.5C19.1393,14.7761,18.915399999999998,15,18.6393,15L3.6392670000000003,15C3.363124,15,3.139267,14.7761,3.139267,14.5ZM13.1889,18C12.98303,18.5826,12.42741,19,11.7743,19C11.12119,19,10.565570000000001,18.5826,10.35965,18L3.778549,18C3.502407,18,3.278549,17.7761,3.278549,17.5C3.278549,17.2239,3.502407,17,3.778549,17L10.35965,17C10.565570000000001,16.4174,11.12119,16,11.7743,16C12.42741,16,12.98303,16.4174,13.1889,17L18.7785,17C19.0547,17,19.2785,17.2239,19.2785,17.5C19.2785,17.7761,19.0547,18,18.7785,18L13.1889,18Z" stroke-opacity="0" stroke="none"></path></svg>'), sB = () => aB.cloneNode(!0), iB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M4.91465,6C4.70873,6.582599999999999,4.15311,7,3.5,7C2.671573,7,2,6.32843,2,5.5C2,4.671573,2.671573,4,3.5,4C4.15311,4,4.70873,4.417404,4.91465,5L18.2257,5C18.5018,5,18.7257,5.22386,18.7257,5.5C18.7257,5.77614,18.5018,6,18.2257,6L4.91465,6ZM2.7257,8.5C2.7257,8.22386,2.949558,8,3.2257,8L18.2257,8C18.5018,8,18.7257,8.22386,18.7257,8.5C18.7257,8.77614,18.5018,9,18.2257,9L3.2257,9C2.949558,9,2.7257,8.77614,2.7257,8.5ZM3.00425,11.5C3.00425,11.22386,3.22811,11,3.50425,11L18.5042,11C18.7804,11,19.0042,11.22386,19.0042,11.5C19.0042,11.77614,18.7804,12,18.5042,12L3.50425,12C3.22811,12,3.00425,11.77614,3.00425,11.5ZM2.864967,14.5C2.864967,14.2239,3.08882,14,3.36497,14L18.365,14C18.6411,14,18.865,14.2239,18.865,14.5C18.865,14.7761,18.6411,15,18.365,15L3.36497,15C3.08882,15,2.864967,14.7761,2.864967,14.5ZM20,17.5C20,18.328400000000002,19.3284,19,18.5,19C17.846899999999998,19,17.2913,18.5826,17.0854,18L3.50425,18C3.22811,18,3.00425,17.7761,3.00425,17.5C3.00425,17.2239,3.22811,17,3.50425,17L17.0854,17C17.2913,16.4174,17.846899999999998,16,18.5,16C19.3284,16,20,16.671599999999998,20,17.5Z" stroke-opacity="0" stroke="none"></path></svg>'), rB = () => iB.cloneNode(!0), cB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><ellipse cx="10.5" cy="11.5" rx="1.5" ry="1.5" stroke-opacity="0" stroke="none"></ellipse><ellipse cx="17.5" cy="11.5" rx="1.5" ry="1.5" stroke-opacity="0" stroke="none"></ellipse><ellipse cx="10.5" cy="11.5" rx="7" ry="7" fill-opacity="0" stroke-opacity="1" fill="none" stroke-width="1"></ellipse><ellipse cx="10.5" cy="11.5" rx="5" ry="5" fill-opacity="0" stroke-opacity="1" fill="none" stroke-width="1"></ellipse><ellipse cx="10.5" cy="11.5" rx="3" ry="3" fill-opacity="0" stroke-opacity="1" fill="none" stroke-width="1"></ellipse></svg>'), lB = () => cB.cloneNode(!0), _B = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M3,7.32468C5.90649,3.3893050000000002,11.49833,2.81306,14.6674,6.31944C14.9056,6.1554199999999994,15.192,6.05979,15.5,6.05979C15.845,6.05979,16.1628,6.17974,16.4162,6.381349999999999L18.4509,4.23827L19,4.816615L16.8945,7.03429C16.962600000000002,7.21075,17,7.40319,17,7.60463C17,8.45782,16.328400000000002,9.14947,15.5,9.14947C14.6716,9.14947,14,8.45782,14,7.60463C14,7.36402,14.0534,7.13625,14.1487,6.93322C11.32695,3.748365,6.25159,4.253956,3.612785,7.82695L3,7.32468ZM14.09,15.4717C15.7427,13.78985,16.244500000000002,11.524740000000001,15.5633,9.30134L15.5618,9.30134L16.3012,9.0502C17.072400000000002,11.56646,16.497700000000002,14.158,14.6282,16.0599C12.28737,18.442,8.62386,18.6988,6.41348,16.4501C4.5526,14.5572,4.52076,11.19671,6.36766,9.3177C7.89069,7.76754,10.07544,7.706189999999999,11.56741,9.22363C11.95453,9.61742,12.24817,10.08363,12.43369,10.57677L14.1451,8.77421L14.6942,9.35256L12.64982,11.50582C12.65827,11.59712,12.66295,11.68839,12.66378,11.77936C12.87398,12.04523,13,12.38451,13,12.7541C13,13.60729,12.32843,14.2989,11.5,14.2989C10.67157,14.2989,10,13.60729,10,12.7541C10,11.90091,10.67157,11.20926,11.5,11.20926C11.60387,11.20926,11.70528,11.220130000000001,11.8032,11.240829999999999L11.81763,11.22564C11.69858,10.71874,11.42858,10.21929,11.0284,9.81179C9.844000000000001,8.60765,8.136890000000001,8.65592,6.90822,9.90586C5.37975,11.460930000000001,5.40693,14.288,6.95404,15.8619C8.84598,17.7867,12.03496,17.5626,14.09,15.4717Z" stroke-opacity="0" stroke="none"></path></svg>'), dB = () => _B.cloneNode(!0), uB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M4,17.0854L4,3.5C4,3.223858,4.22386,3,4.5,3C4.77614,3,5,3.223858,5,3.5L5,10L7.57584,10L9.8127,4.46359C9.91614,4.20756,10.20756,4.08386,10.46359,4.1873000000000005C10.71963,4.29075,10.84333,4.58216,10.73988,4.8382000000000005L8.65438,10L11.08535,10C11.29127,9.4174,11.84689,9,12.5,9C12.65154,9,12.79784,9.02247,12.93573,9.06427L16.6464,5.35355C16.8417,5.15829,17.1583,5.15829,17.3536,5.35355C17.5488,5.54882,17.5488,5.8654,17.3536,6.06066L13.7475,9.66675C13.907,9.90508,14,10.19168,14,10.5C14,11.15311,13.5826,11.70873,13,11.91465L13,14.3638L18.3714,12.1936C18.6274,12.09015,18.918799999999997,12.21385,19.0222,12.46989C19.1257,12.72592,19.002,13.0173,18.746000000000002,13.1208L13,15.4423L13,18L19.5,18C19.7761,18,20,18.2239,20,18.5C20,18.7761,19.7761,19,19.5,19L5.91465,19C5.70873,19.5826,5.15311,20,4.5,20C3.671573,20,3,19.3284,3,18.5C3,17.846899999999998,3.417404,17.2913,4,17.0854ZM6.3729499999999994,17.0413L12,14.7678L12,11.91465C11.88136,11.87271,11.76956,11.81627,11.66675,11.74746L6.3729499999999994,17.0413ZM12,15.8463L6.6694700000000005,18L12,18L12,15.8463ZM6.38629,15.6137L8.250350000000001,11L11,11L6.38629,15.6137ZM5,11L7.17182,11L5,16.3754L5,11Z" stroke-opacity="0" fill-rule="evenodd" fill-opacity="1"></path></svg>'), $B = () => uB.cloneNode(!0), gB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M17,4.5C17,5.32843,16.328400000000002,6,15.5,6C15.0931,6,14.7241,5.83802,14.4539,5.57503L5.98992,8.32515C5.99658,8.38251,6,8.440850000000001,6,8.5C6,9.15311,5.582599999999999,9.70873,5,9.91465L5,11.08535C5.42621,11.236,5.763999999999999,11.57379,5.91465,12L19.5,12C19.7761,12,20,12.22386,20,12.5C20,12.77614,19.7761,13,19.5,13L5.91465,13C5.70873,13.5826,5.15311,14,4.5,14C3.671573,14,3,13.3284,3,12.5C3,11.84689,3.417404,11.29127,4,11.08535L4,9.91465C3.417404,9.70873,3,9.15311,3,8.5C3,7.67157,3.671573,7,4.5,7C4.90411,7,5.2709,7.15981,5.5406200000000005,7.41967L14.0093,4.66802C14.0032,4.6128599999999995,14,4.5568,14,4.5C14,3.671573,14.6716,3,15.5,3C16.328400000000002,3,17,3.671573,17,4.5ZM4,15.5C4,15.2239,4.22386,15,4.5,15L19.5,15C19.7761,15,20,15.2239,20,15.5C20,15.7761,19.7761,16,19.5,16L4.5,16C4.22386,16,4,15.7761,4,15.5ZM4,18.5C4,18.2239,4.22386,18,4.5,18L19.5,18C19.7761,18,20,18.2239,20,18.5C20,18.7761,19.7761,19,19.5,19L4.5,19C4.22386,19,4,18.7761,4,18.5Z" stroke-opacity="0" stroke="none"></path></svg>'), hB = () => gB.cloneNode(!0), mB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M20,3.5C20,4.15311,19.5826,4.70873,19,4.91465L19,18.5C19,18.7761,18.7761,19,18.5,19L4.91465,19C4.70873,19.5826,4.15311,20,3.5,20C2.671573,20,2,19.3284,2,18.5C2,17.846899999999998,2.417404,17.2913,3,17.0854L3,3.5C3,3.22386,3.22386,3,3.5,3L17.0854,3C17.2913,2.417404,17.846899999999998,2,18.5,2C19.3284,2,20,2.671573,20,3.5ZM17.0854,4C17.236,4.42621,17.5738,4.763999999999999,18,4.91465L18,8L14,8L14,4L17.0854,4ZM13,4L13,8L9,8L9,4L13,4ZM13,9L9,9L9,13L13,13L13,9ZM13,14L9,14L9,18L13,18L13,14ZM14,18L14,14L18,14L18,18L14,18ZM18,13L14,13L14,9L18,9L18,13ZM4.91465,18C4.763999999999999,17.5738,4.42621,17.236,4,17.0854L4,14L8,14L8,18L4.91465,18ZM4,8L4,4L8,4L8,8L4,8ZM8,9L8,13L4,13L4,9L8,9Z" stroke-opacity="0" fill-rule="evenodd" fill-opacity="1"></path></svg>'), pB = () => mB.cloneNode(!0), fB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><ellipse cx="10.5" cy="11.5" rx="1.5" ry="1.5" stroke-opacity="0" stroke="none"></ellipse><ellipse cx="17.5" cy="11.5" rx="1.5" ry="1.5" stroke-opacity="0" stroke="none"></ellipse><ellipse cx="10.5" cy="11.5" rx="7" ry="7" fill-opacity="0" fill="none" stroke-opacity="1" stroke-width="1"></ellipse></svg>'), yB = () => fB.cloneNode(!0), CB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M11.57625,6.9981C11.55099,6.999359999999999,11.52557,7,11.5,7C11.34,7,11.18584,6.97495,11.04125,6.9285499999999995L5.55401,16.4327C5.713760000000001,16.5905,5.83826,16.7839,5.91465,17L16.0854,17C16.2187,16.622700000000002,16.4987,16.314700000000002,16.8569,16.1445L11.57625,6.9981ZM12.50759,6.611219999999999C12.81005,6.336790000000001,13,5.94058,13,5.5C13,4.671573,12.32843,4,11.5,4C10.67157,4,10,4.671573,10,5.5C10,5.80059,10.08841,6.08052,10.24066,6.31522L4.64514,16.0069C4.59738,16.002299999999998,4.54896,16,4.5,16C3.671573,16,3,16.671599999999998,3,17.5C3,18.328400000000002,3.671573,19,4.5,19C5.15311,19,5.70873,18.5826,5.91465,18L16.0854,18C16.2913,18.5826,16.846899999999998,19,17.5,19C18.328400000000002,19,19,18.328400000000002,19,17.5C19,16.8365,18.5691,16.2735,17.971899999999998,16.075699999999998L12.50759,6.611219999999999Z" stroke-opacity="0" fill-rule="evenodd" fill-opacity="1"></path></svg>'), bB = () => CB.cloneNode(!0), vB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M19,4.5C19,5.15311,18.5826,5.70873,18,5.91465L18,18.5C18,18.7761,17.7761,19,17.5,19L5.91465,19C5.70873,19.5826,5.15311,20,4.5,20C3.671573,20,3,19.3284,3,18.5C3,17.846899999999998,3.417404,17.2913,4,17.0854L4,4.5C4,4.22386,4.22386,4,4.5,4L16.0854,4C16.2913,3.417404,16.846899999999998,3,17.5,3C18.328400000000002,3,19,3.671573,19,4.5ZM5,5L16.0854,5C16.236,5.42621,16.5738,5.763999999999999,17,5.91465L17,18L5.91465,18C5.763999999999999,17.5738,5.42621,17.236,5,17.0854L5,5Z" stroke-opacity="0" fill-rule="evenodd" fill-opacity="1"></path></svg>'), LB = () => vB.cloneNode(!0), xB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M19.6401,7.99355C20.4028,7.92291,21,7.2811900000000005,21,6.5C21,5.671573,20.3284,5,19.5,5C18.8469,5,18.2913,5.417404,18.0854,6L7.62067,6C7.34453,6,7.12067,6.22386,7.12067,6.5C7.12067,6.5479,7.12741,6.59423,7.13999,6.63809L3.2294099999999997,15.0243C2.530138,15.1517,2,15.764,2,16.5C2,17.328400000000002,2.671573,18,3.5,18C4.15311,18,4.70873,17.5826,4.91465,17L14.5963,17C14.6456,17.076,14.7162,17.1396,14.8044,17.1807C15.0546,17.2974,15.3521,17.1891,15.4688,16.9388L19.6401,7.99355ZM14.7896,16.0293L18.6551,7.739599999999999C18.3942,7.56144,18.1925,7.30307,18.0854,7L8.0746,7L4.25044,15.2009C4.55701,15.3784,4.79493,15.6613,4.91465,16L14.6207,16C14.68,16,14.7368,16.0103,14.7896,16.0293Z" stroke-opacity="0" fill-rule="evenodd" fill-opacity="1"></path></svg>'), wB = () => xB.cloneNode(!0), kB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M8.134443814697265,7.494615087890625L8.764323814697265,7.494615087890625L8.764323814697265,3.414215087890625L8.310223814697267,3.414215087890625L7.294603814697266,4.005035087890625L7.289713814697266,4.634915087890625L8.134443814697265,4.149892087890625L8.134443814697265,7.494615087890625ZM18.832003814697266,6.933095087890624Q19.004603814697266,6.635245087890625,19.004603814697266,6.2543850878906255Q19.004603814697266,5.884915087890625,18.845103814697264,5.593575087890625Q18.685503814697267,5.3006050878906255,18.399103814697266,5.136225087890625Q18.114303814697266,4.9702050878906245,17.754603814697266,4.9653250878906245L18.820603814697265,3.840647087890625L18.820603814697265,3.414215087890625L16.519203814697264,3.414215087890625L16.519203814697264,3.939931087890625L18.050803814697264,3.939931087890625L16.719403814697266,5.334785087890625L17.074203814697263,5.7205350878906245Q17.254903814697265,5.484525087890625,17.619503814697268,5.484525087890625Q17.980803814697268,5.484525087890625,18.187503814697266,5.689605087890625Q18.394203814697267,5.894685087890625,18.394203814697267,6.2543850878906255Q18.394203814697267,6.604315087890625,18.187503814697266,6.822415087890625Q17.980803814697268,7.0405150878906255,17.640603814697265,7.0405150878906255Q17.334603814697267,7.0405150878906255,17.124703814697266,6.890775087890625Q16.914703814697265,6.739415087890626,16.820303814697265,6.469225087890624L16.354803814697263,6.744295087890626Q16.480103814697266,7.125155087890625,16.821903814697265,7.341625087890625Q17.165403814697264,7.559725087890625,17.640603814697265,7.559725087890625Q18.039403814697266,7.559725087890625,18.348603814697267,7.393705087890625Q18.659503814697267,7.229315087890625,18.832003814697266,6.933095087890624ZM10.000003814697266,10.634915087890626C10.000003814697266,11.024655087890626,9.851363814697265,11.379685087890625,9.607683814697266,11.646395087890625L12.168903814697266,15.171615087890626C12.275403814697265,15.147615087890625,12.386203814697266,15.134915087890626,12.500003814697266,15.134915087890626C12.596503814697266,15.134915087890626,12.690803814697265,15.144015087890624,12.782303814697265,15.161415087890624L16.108803814697268,11.196955087890625C16.038703814697264,11.023375087890624,16.000003814697266,10.833655087890625,16.000003814697266,10.634915087890626C16.000003814697266,9.806495087890625,16.671603814697264,9.134915087890626,17.500003814697266,9.134915087890626C18.328403814697264,9.134915087890626,19.000003814697266,9.806495087890625,19.000003814697266,10.634915087890626C19.000003814697266,11.463345087890625,18.328403814697264,12.134915087890626,17.500003814697266,12.134915087890626C17.239503814697265,12.134915087890626,16.994503814697268,12.068495087890625,16.781003814697264,11.951675087890624L13.654703814697266,15.677415087890624C13.870303814697266,15.937215087890625,14.000003814697266,16.270915087890625,14.000003814697266,16.634915087890626C14.000003814697266,17.463315087890624,13.328403814697266,18.134915087890626,12.500003814697266,18.134915087890626C11.671573814697265,18.134915087890626,11.000003814697266,17.463315087890624,11.000003814697266,16.634915087890626C11.000003814697266,16.284415087890626,11.120193814697265,15.962015087890626,11.321603814697266,15.706715087890625L8.715393814697265,12.119565087890624C8.645053814697267,12.129685087890625,8.573143814697266,12.134915087890626,8.500003814697266,12.134915087890626C8.162103814697264,12.134915087890626,7.8503038146972655,12.023195087890626,7.599523814697266,11.834665087890626L4.505583814697266,15.521915087890624C4.809213814697266,15.796415087890624,5.000003814697266,16.193415087890624,5.000003814697266,16.634915087890626C5.000003814697266,17.463315087890624,4.328433814697266,18.134915087890626,3.5000038146972656,18.134915087890626C2.6715768146972656,18.134915087890626,2.0000038146972656,17.463315087890624,2.0000038146972656,16.634915087890626C2.0000038146972656,15.806515087890626,2.6715768146972656,15.134915087890626,3.5000038146972656,15.134915087890626C3.508253814697266,15.134915087890626,3.5164838146972657,15.135015087890626,3.524703814697266,15.135115087890625L7.033823814697266,10.953115087890625C7.011673814697265,10.850565087890626,7.000003814697266,10.744105087890624,7.000003814697266,10.634915087890626C7.000003814697266,9.806495087890625,7.671573814697266,9.134915087890626,8.500003814697266,9.134915087890626C9.328433814697267,9.134915087890626,10.000003814697266,9.806495087890625,10.000003814697266,10.634915087890626Z" stroke-opacity="0" stroke="none"></path></svg>'), AB = () => kB.cloneNode(!0), TB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M8.13444,7.494615087890625L8.76432,7.494615087890625L8.76432,3.414215087890625L8.310220000000001,3.414215087890625L7.2946,4.005035087890625L7.28971,4.634915087890625L8.13444,4.149892087890625L8.13444,7.494615087890625ZM18.832,6.929835087890625Q19.0046,6.635245087890625,19.0046,6.2543850878906255Q19.0046,5.889805087890625,18.8451,5.5952050878906245Q18.6855,5.3006050878906255,18.3975,5.132965087890625Q18.1094,4.9653250878906245,17.7399,4.9653250878906245Q17.435499999999998,4.9653250878906245,17.1556,5.149245087890625L17.2793,3.939931087890625L18.8304,3.939931087890625L18.8304,3.414215087890625L16.7406,3.414215087890625L16.5094,5.665195087890625L17.0156,5.795405087890625Q17.095399999999998,5.655425087890626,17.2516,5.570795087890625Q17.4095,5.484525087890625,17.6357,5.484525087890625Q17.9694,5.484525087890625,18.1842,5.697745087890625Q18.4007,5.909335087890625,18.4007,6.2543850878906255Q18.4007,6.604315087890625,18.1842,6.822415087890625Q17.9694,7.0405150878906255,17.6292,7.0405150878906255Q17.3298,7.0405150878906255,17.119799999999998,6.890775087890625Q16.9098,6.739415087890626,16.825200000000002,6.474115087890625L16.3597,6.749175087890626Q16.470399999999998,7.110505087890624,16.807299999999998,7.335115087890625Q17.144199999999998,7.559725087890625,17.6292,7.559725087890625Q18.0296,7.559725087890625,18.3438,7.392075087890625Q18.6595,7.224435087890625,18.832,6.929835087890625ZM10,10.634915087890626C10,11.024655087890626,9.85136,11.379685087890625,9.60768,11.646395087890625L12.1689,15.171615087890626C12.2754,15.147615087890625,12.3862,15.134915087890626,12.5,15.134915087890626C12.5965,15.134915087890626,12.6908,15.144015087890624,12.7823,15.161415087890624L16.108800000000002,11.196955087890625C16.0387,11.023375087890624,16,10.833655087890625,16,10.634915087890626C16,9.806495087890625,16.671599999999998,9.134915087890626,17.5,9.134915087890626C18.3284,9.134915087890626,19,9.806495087890625,19,10.634915087890626C19,11.463345087890625,18.3284,12.134915087890626,17.5,12.134915087890626C17.2395,12.134915087890626,16.994500000000002,12.068505087890625,16.781,11.951675087890624L13.6547,15.677415087890624C13.8703,15.937215087890625,14,16.270915087890625,14,16.634915087890626C14,17.463315087890624,13.3284,18.134915087890626,12.5,18.134915087890626C11.67157,18.134915087890626,11,17.463315087890624,11,16.634915087890626C11,16.284415087890626,11.12019,15.962015087890626,11.3216,15.706715087890625L8.71539,12.119565087890624C8.645050000000001,12.129685087890625,8.57314,12.134915087890626,8.5,12.134915087890626C8.162099999999999,12.134915087890626,7.8503,12.023195087890626,7.59952,11.834665087890626L4.50558,15.521915087890624C4.80921,15.796415087890624,5,16.193415087890624,5,16.634915087890626C5,17.463315087890624,4.32843,18.134915087890626,3.5,18.134915087890626C2.671573,18.134915087890626,2,17.463315087890624,2,16.634915087890626C2,15.806515087890626,2.671573,15.134915087890626,3.5,15.134915087890626C3.5082500000000003,15.134915087890626,3.51648,15.135015087890626,3.5247,15.135115087890625L7.03382,10.953115087890625C7.01167,10.850565087890626,7,10.744105087890624,7,10.634915087890626C7,9.806495087890625,7.67157,9.134915087890626,8.5,9.134915087890626C9.32843,9.134915087890626,10,9.806495087890625,10,10.634915087890626Z" stroke-opacity="0" stroke="none"></path></svg>'), MB = () => TB.cloneNode(!0), SB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M18.8532,7.020985087890625Q19.0257,6.734525087890625,19.0257,6.369945087890625Q19.0257,6.020005087890625,18.8499,5.754705087890625Q18.6758,5.489415087890626,18.3649,5.339675087890625Q18.5944,5.209465087890625,18.7214,4.994615087890625Q18.8499,4.779775087890625,18.8499,4.5193550878906255Q18.8499,4.2003480878906245,18.7002,3.951324087890625Q18.5505,3.700673087890625,18.277,3.557444087890625Q18.0052,3.414215087890625,17.6455,3.414215087890625Q17.285800000000002,3.414215087890625,17.0107,3.557444087890625Q16.7357,3.700673087890625,16.5843,3.951324087890625Q16.4346,4.2003480878906245,16.4346,4.5193550878906255Q16.4346,4.779775087890625,16.561500000000002,4.994615087890625Q16.6901,5.209465087890625,16.919600000000003,5.339675087890625Q16.6055,5.489415087890626,16.4297,5.757965087890625Q16.255499999999998,6.024895087890625,16.255499999999998,6.369945087890625Q16.255499999999998,6.734525087890625,16.4297,7.020985087890625Q16.6055,7.305815087890625,16.919600000000003,7.465325087890625Q17.2354,7.624825087890625,17.6455,7.624825087890625Q18.0557,7.624825087890625,18.3682,7.465325087890625Q18.6807,7.305815087890625,18.8532,7.020985087890625ZM8.76432,7.559725087890625L8.13444,7.559725087890625L8.13444,4.214996087890625L7.28971,4.700025087890625L7.2946,4.070139087890625L8.310220000000001,3.479319087890625L8.76432,3.479319087890625L8.76432,7.559725087890625ZM17.1816,4.955555087890625Q17.0042,4.784655087890625,17.0042,4.5095950878906255Q17.0042,4.229645087890625,17.18,4.057119087890625Q17.355800000000002,3.884592087890625,17.6455,3.884592087890625Q17.935200000000002,3.884592087890625,18.1077,4.057119087890625Q18.2803,4.229645087890625,18.2803,4.5095950878906255Q18.2803,4.784655087890625,18.1045,4.955555087890625Q17.930300000000003,5.124825087890625,17.6455,5.124825087890625Q17.3607,5.124825087890625,17.1816,4.955555087890625ZM18.2217,5.7953950878906255Q18.4398,6.005365087890625,18.4398,6.3552950878906245Q18.4398,6.705235087890625,18.2217,6.915195087890625Q18.0052,7.125155087890625,17.6455,7.125155087890625Q17.285800000000002,7.125155087890625,17.067700000000002,6.915195087890625Q16.849600000000002,6.705235087890625,16.849600000000002,6.3552950878906245Q16.849600000000002,6.005365087890625,17.064500000000002,5.7953950878906255Q17.2793,5.585435087890625,17.6455,5.585435087890625Q18.0052,5.585435087890625,18.2217,5.7953950878906255ZM9.60768,11.711495087890626C9.85136,11.444785087890626,10,11.089765087890626,10,10.700025087890625C10,9.871595087890626,9.32843,9.200025087890625,8.5,9.200025087890625C7.67157,9.200025087890625,7,9.871595087890626,7,10.700025087890625C7,10.809205087890625,7.01167,10.915665087890625,7.03382,11.018215087890624L3.5247,15.200215087890625C3.51648,15.200115087890625,3.5082500000000003,15.200015087890625,3.5,15.200015087890625C2.671573,15.200015087890625,2,15.871615087890625,2,16.700015087890627C2,17.528415087890625,2.671573,18.200015087890627,3.5,18.200015087890627C4.32843,18.200015087890627,5,17.528415087890625,5,16.700015087890627C5,16.258515087890625,4.80921,15.861515087890625,4.50558,15.587015087890626L7.59952,11.899765087890625C7.8503,12.088295087890625,8.162099999999999,12.200025087890625,8.5,12.200025087890625C8.57314,12.200025087890625,8.645050000000001,12.194785087890626,8.71539,12.184675087890625L11.3216,15.771815087890625C11.12019,16.027215087890625,11,16.349515087890623,11,16.700015087890627C11,17.528415087890625,11.67157,18.200015087890627,12.5,18.200015087890627C13.3284,18.200015087890627,14,17.528415087890625,14,16.700015087890627C14,16.336015087890623,13.8703,16.002315087890626,13.6547,15.742515087890625L16.781,12.016775087890625C16.994500000000002,12.133605087890626,17.2395,12.200025087890625,17.5,12.200025087890625C18.3284,12.200025087890625,19,11.528445087890624,19,10.700025087890625C19,9.871595087890626,18.3284,9.200025087890625,17.5,9.200025087890625C16.671599999999998,9.200025087890625,16,9.871595087890626,16,10.700025087890625C16,10.898765087890624,16.0387,11.088475087890625,16.108800000000002,11.262055087890625L12.7823,15.226515087890625C12.6908,15.209115087890625,12.5965,15.200015087890625,12.5,15.200015087890625C12.3862,15.200015087890625,12.2754,15.212715087890626,12.1689,15.236715087890625L9.60768,11.711495087890626Z" stroke-opacity="0" stroke="none"></path></svg>'), DB = () => SB.cloneNode(!0), IB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M9.474616630859375,7.494615087890625L8.844736630859375,7.494615087890625L8.844736630859375,4.149892087890625L8.000006630859374,4.634915087890625L8.004896630859374,4.005035087890625L9.020516630859376,3.414215087890625L9.474616630859375,3.414215087890625L9.474616630859375,7.494615087890625ZM18.529296630859378,4.8318550878906255Q18.307996630859375,5.028795087890625,18.122396630859377,5.385245087890625Q17.868496630859376,5.019035087890625,17.629196630859376,4.8269750878906255Q17.389996630859375,4.634915087890625,17.168596630859376,4.634915087890625Q16.794296630859375,4.634915087890625,16.522496630859376,4.976715087890625Q16.252296630859377,5.3168850878906255,16.252296630859377,5.7856350878906255Q16.252296630859377,6.218575087890625,16.502896630859375,6.521315087890625Q16.755196630859373,6.822415087890625,17.114896630859377,6.822415087890625Q17.368796630859375,6.822415087890625,17.588596630859374,6.625475087890624Q17.809896630859377,6.428535087890625,17.998696630859374,6.0688350878906245Q18.249396630859373,6.439935087890625,18.488596630859377,6.631985087890625Q18.727896630859377,6.822415087890625,18.952496630859375,6.822415087890625Q19.326796630859373,6.822415087890625,19.596996630859376,6.482245087890625Q19.868796630859375,6.140455087890626,19.868796630859375,5.671705087890626Q19.868796630859375,5.238755087890625,19.618196630859376,4.937655087890625Q19.367496630859375,4.634915087890625,19.006196630859375,4.634915087890625Q18.750696630859377,4.634915087890625,18.529296630859378,4.8318550878906255ZM18.337296630859377,5.674955087890625L18.278696630859375,5.596835087890625Q18.449596630859375,5.272935087890625,18.622096630859374,5.1101750878906245Q18.794596630859374,4.947415087890625,18.967096630859373,4.947415087890625Q19.194996630859375,4.947415087890625,19.346396630859374,5.1345950878906255Q19.497696630859377,5.320135087890625,19.497696630859377,5.598455087890625Q19.497696630859377,5.8914250878906245,19.360996630859376,6.096505087890625Q19.224296630859374,6.301585087890626,19.027396630859375,6.301585087890626Q18.915096630859374,6.301585087890626,18.742496630859375,6.146965087890624Q18.569996630859375,5.992335087890625,18.337296630859377,5.674955087890625ZM17.785496630859377,5.779125087890625L17.842496630859372,5.857245087890625Q17.668296630859373,6.186025087890625,17.495796630859374,6.348785087890625Q17.324896630859374,6.509915087890625,17.153996630859375,6.509915087890625Q16.926096630859377,6.509915087890625,16.774796630859377,6.324375087890624Q16.623396630859375,6.137195087890625,16.623396630859375,5.858875087890625Q16.623396630859375,5.565905087890625,16.761696630859376,5.360825087890625Q16.900096630859373,5.1557550878906255,17.095396630859376,5.1557550878906255Q17.228896630859374,5.1557550878906255,17.365596630859375,5.2778250878906245Q17.502296630859377,5.399895087890625,17.785496630859377,5.779125087890625ZM10.710296630859375,10.634915087890626C10.710296630859375,11.024655087890626,10.561656630859375,11.379685087890625,10.317976630859375,11.646395087890625L12.879196630859376,15.171615087890626C12.985696630859374,15.147615087890625,13.096496630859376,15.134915087890626,13.210296630859375,15.134915087890626C13.306796630859376,15.134915087890626,13.401096630859374,15.144015087890624,13.492596630859374,15.161415087890624L16.819096630859377,11.196955087890625C16.748996630859374,11.023375087890624,16.710296630859375,10.833655087890625,16.710296630859375,10.634915087890626C16.710296630859375,9.806495087890625,17.381896630859373,9.134915087890626,18.210296630859375,9.134915087890626C19.038696630859373,9.134915087890626,19.710296630859375,9.806495087890625,19.710296630859375,10.634915087890626C19.710296630859375,11.463345087890625,19.038696630859373,12.134915087890626,18.210296630859375,12.134915087890626C17.949796630859375,12.134915087890626,17.704796630859377,12.068505087890625,17.491296630859374,11.951675087890624L14.364996630859375,15.677415087890624C14.580596630859375,15.937215087890625,14.710296630859375,16.270915087890625,14.710296630859375,16.634915087890626C14.710296630859375,17.463315087890624,14.038696630859375,18.134915087890626,13.210296630859375,18.134915087890626C12.381866630859374,18.134915087890626,11.710296630859375,17.463315087890624,11.710296630859375,16.634915087890626C11.710296630859375,16.284415087890626,11.830486630859374,15.962015087890626,12.031896630859375,15.706715087890625L9.425686630859374,12.119565087890624C9.355346630859376,12.129685087890625,9.283436630859375,12.134915087890626,9.210296630859375,12.134915087890626C8.872396630859374,12.134915087890626,8.560596630859376,12.023195087890626,8.309816630859375,11.834665087890626L5.215876630859375,15.521915087890624C5.519506630859375,15.796415087890624,5.710296630859375,16.193415087890624,5.710296630859375,16.634915087890626C5.710296630859375,17.463315087890624,5.038726630859375,18.134915087890626,4.210296630859375,18.134915087890626C3.381869630859375,18.134915087890626,2.710296630859375,17.463315087890624,2.710296630859375,16.634915087890626C2.710296630859375,15.806515087890626,3.381869630859375,15.134915087890626,4.210296630859375,15.134915087890626C4.218546630859375,15.134915087890626,4.226776630859375,15.135015087890626,4.234996630859375,15.135115087890625L7.744116630859375,10.953115087890625C7.721966630859375,10.850565087890626,7.710296630859375,10.744105087890624,7.710296630859375,10.634915087890626C7.710296630859375,9.806495087890625,8.381866630859374,9.134915087890626,9.210296630859375,9.134915087890626C10.038726630859376,9.134915087890626,10.710296630859375,9.806495087890625,10.710296630859375,10.634915087890626Z" stroke-opacity="0" stroke="none"></path></svg>'), BB = () => IB.cloneNode(!0), UB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M21,5.5C21,6.32843,20.3284,7,19.5,7C19.4136,7,19.3289,6.99269,19.2465,6.97866L15.6257,15.5086C15.8587,15.7729,16,16.119999999999997,16,16.5C16,17.328400000000002,15.3284,18,14.5,18C13.8469,18,13.2913,17.5826,13.0854,17L3.91465,17C3.70873,17.5826,3.15311,18,2.5,18C1.671573,18,1,17.328400000000002,1,16.5C1,15.6716,1.671573,15,2.5,15C2.5840199999999998,15,2.66643,15.0069,2.74668,15.0202L6.36934,6.48574C6.13933,6.22213,6,5.87733,6,5.5C6,4.671573,6.67157,4,7.5,4C8.15311,4,8.70873,4.417404,8.91465,5L18.0854,5C18.2913,4.417404,18.8469,4,19.5,4C20.3284,4,21,4.671573,21,5.5ZM18.0854,6L8.91465,6C8.892579999999999,6.06243,8.8665,6.12296,8.83672,6.18128L13.9814,15.0921C14.143,15.0325,14.3177,15,14.5,15C14.584,15,14.6664,15.0069,14.7467,15.0202L18.3693,6.48574C18.2462,6.3446,18.149,6.1802,18.0854,6ZM13.2036,15.745L8.0861,6.8811800000000005C7.90605,6.95768,7.70797,7,7.5,7C7.41359,7,7.32888,6.99269,7.24647,6.97866L3.62571,15.5086C3.7512,15.651,3.8501,15.8174,3.91465,16L13.0854,16C13.1169,15.9108,13.1566,15.8255,13.2036,15.745Z" stroke-opacity="0" stroke="none"></path></svg>'), PB = () => UB.cloneNode(!0), zB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M5.92159,5.93994C6.04014,5.90529,6.152620000000001,5.85639,6.25704,5.79523L9.12729,9.89437C9.045449999999999,10.07959,9,10.28449,9,10.5C9,10.79522,9.08529,11.07053,9.232569999999999,11.30262L4.97573,16.7511L5.92159,5.93994ZM4.92259,5.8848400000000005C4.38078,5.658659999999999,4,5.1238,4,4.5C4,3.671573,4.67157,3,5.5,3C6.2157,3,6.81433,3.50124,6.96399,4.17183L15.1309,4.88634C15.3654,4.36387,15.8902,4,16.5,4C17.328400000000002,4,18,4.67157,18,5.5C18,6.08983,17.659599999999998,6.60015,17.1645,6.84518L18.4264,14.0018C18.4508,14.0006,18.4753,14,18.5,14C19.3284,14,20,14.6716,20,15.5C20,16.328400000000002,19.3284,17,18.5,17C17.932499999999997,17,17.4386,16.6849,17.183799999999998,16.22L5.99686,18.5979C5.946429999999999,19.3807,5.29554,20,4.5,20C3.671573,20,3,19.3284,3,18.5C3,17.869300000000003,3.389292,17.3295,3.94071,17.1077L4.92259,5.8848400000000005ZM5.72452,17.6334C5.69799,17.596,5.6698,17.5599,5.64004,17.525100000000002L10.01843,11.92103C10.16958,11.97223,10.33155,12,10.5,12C10.80059,12,11.08052,11.91158,11.31522,11.75934L17.0606,15.0765C17.0457,15.1271,17.0335,15.1789,17.023899999999998,15.2317L5.72452,17.6334ZM11.92855,10.95875L17.4349,14.1379L16.1699,6.96356C15.9874,6.92257,15.8174,6.8483,15.6667,6.74746L11.99771,10.4165C11.99923,10.44414,12,10.47198,12,10.5C12,10.66,11.97495,10.814160000000001,11.92855,10.95875ZM10.5,9C10.259830000000001,9,10.03285,9.05644,9.83159,9.15679L7.04919,5.1831L15.0493,5.88302C15.054,5.90072,15.059,5.91829,15.0643,5.9357299999999995L11.56066,9.43934C11.28921,9.16789,10.91421,9,10.5,9Z" stroke-opacity="0" fill-rule="evenodd" fill-opacity="1"></path></svg>'), RB = () => zB.cloneNode(!0), NB = /* @__PURE__ */ g('<svg viewBox="0 0 22 22"><path d="M4.727219638671875,8.007996215820313L9.973849638671876,2.7629472158203123C10.167279638671875,2.5696791158203123,10.480729638671875,2.5696791158203123,10.674169638671875,2.7629472158203123L13.223329638671874,5.311756215820313C13.416929638671874,5.505236215820313,13.416929638671874,5.8189862158203125,13.223329638671874,6.012466215820313L7.977129638671875,11.257906215820313C7.379859638671875,11.855176215820313,7.407609638671875,12.909396215820312,8.033809638671876,13.535596215820313C8.660409638671876,14.162596215820313,9.713849638671874,14.189996215820312,10.311129638671876,13.591896215820313L15.556929638671875,8.346066215820311C15.750429638671875,8.152526215820313,16.064229638671875,8.152526215820313,16.257629638671872,8.346066215820311L18.806529638671876,10.895266215820312C19.000029638671876,11.088746215820313,19.000029638671876,11.402496215820312,18.806529638671876,11.595976215820313L13.560629638671875,16.841796215820313C11.165619638671876,19.237196215820312,7.197149638671875,19.19919621582031,4.783499638671875,16.785496215820313C2.3698426386718747,14.371896215820312,2.331397638671875,10.403416215820313,4.727219638671875,8.007996215820313ZM12.172299638671875,5.662106215820312L10.323809638671875,3.8136162158203124L5.4287196386718755,8.709096215820313C3.422893638671875,10.714536215820312,3.4549956386718748,14.055196215820313,5.484999638671875,16.08479621582031C7.514609638671875,18.114796215820313,10.855289638671875,18.146496215820314,12.860719638671876,16.141096215820312L15.465629638671874,13.535796215820312L14.090929638671875,12.160756215820312L14.791629638671875,11.460436215820312L16.166229638671876,12.834996215820313L17.755829638671877,11.245226215820313L15.907729638671874,9.396736215820312L11.011839638671875,14.292596215820312C10.042809638671875,15.262396215820312,8.418249638671874,15.243796215820312,7.406019638671875,14.306496215820312L7.333099638671875,14.236296215820312C6.327599638671876,13.230796215820313,6.284009638671876,11.550396215820312,7.276419638671875,10.557586215820312L9.882199638671874,7.952026215820313L8.501079638671875,6.570906215820313L9.201789638671876,5.870186215820313L10.582939638671874,7.251336215820312L12.172299638671875,5.662106215820312Z" stroke-opacity="0" fill-rule="evenodd" fill-opacity="1"></path></svg>'), OB = (e) => (() => {
  const t = NB.cloneNode(!0);
  return W(t, "class", `icon-overlay ${e ?? ""}`), t;
})(), EB = /* @__PURE__ */ g('<svg viewBox="0 0 22 22"><defs><clipPath id="master_svg0_151_615"><rect x="0" y="0" width="22" height="22" rx="0"></rect></clipPath></defs><g clip-path="url(#master_svg0_151_615)"><path d="M19.672,3.0673368C19.4417,2.9354008,19.1463,3.00292252,18.9994,3.2210900000000002L17.4588,5.50622L16.743299999999998,3.781253L13.9915,7.4662L13.9618,7.51108C13.8339,7.72862,13.8936,8.005659999999999,14.1004,8.15391L14.1462,8.183430000000001C14.3683,8.308720000000001,14.6511,8.25001,14.8022,8.047229999999999L16.4907,5.78571L17.246299999999998,7.60713L19.8374,3.7635389999999997L19.8651,3.717088C19.9871,3.484615,19.9023,3.199273,19.672,3.0673368ZM4.79974,8.462530000000001L10.117740000000001,3.252975C10.31381,3.0610145,10.63152,3.0610145,10.82759,3.252975L13.4115,5.78453C13.6076,5.976710000000001,13.6076,6.28833,13.4115,6.4805L8.093869999999999,11.69045C7.48847,12.28368,7.51659,13.3308,8.151309999999999,13.9528C8.786439999999999,14.5755,9.85421,14.6027,10.45961,14.0087L15.7768,8.79831C15.9729,8.60609,16.2909,8.60609,16.487099999999998,8.79831L19.0705,11.33026C19.2667,11.52244,19.2667,11.83406,19.0705,12.02623L13.7533,17.2366C11.32572,19.6158,7.30328,19.578,4.85679,17.1807C2.410298,14.7834,2.371331,10.84174,4.79974,8.462530000000001ZM12.3461,6.1325199999999995L10.47246,4.29654L5.51079,9.15889C3.477674,11.15076,3.510214,14.4688,5.56784,16.4847C7.62506,18.500999999999998,11.01117,18.5325,13.0439,16.540599999999998L15.6842,13.9529L14.2908,12.58718L15.0011,11.89161L16.394399999999997,13.2569L18.0056,11.67786L16.1323,9.84188L11.16985,14.7046C10.18764,15.6679,8.540980000000001,15.6494,7.51498,14.7184L7.44107,14.6487C6.4219,13.65,6.37771,11.98096,7.38362,10.994869999999999L10.02485,8.40693L8.624939999999999,7.03516L9.335180000000001,6.33919L10.73512,7.71099L12.3461,6.1325199999999995Z" stroke-opacity="0" fill-rule="evenodd" fill-opacity="1"></path></g></svg>'), jB = (e) => (() => {
  const t = EB.cloneNode(!0);
  return W(t, "class", `icon-overlay ${e ?? ""}`), t;
})(), FB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M11,17C5.80945,17,3.667717,12.85,3.113386,11.575C2.9622047,11.2,2.9622047,10.8,3.113386,10.425C3.667717,9.15,5.80945,5,11,5C16.165399999999998,5,18.3323,9.15,18.8866,10.425C19.0378,10.8,19.0378,11.2,18.8866,11.575C18.3323,12.85,16.165399999999998,17,11,17ZM4.04567,10.8C3.995276,10.925,3.995276,11.05,4.04567,11.175C4.52441,12.325,6.43937,16,11,16C15.5606,16,17.4756,12.325,17.9543,11.2C18.0047,11.075,18.0047,10.95,17.9543,10.825C17.4756,9.675,15.5606,6,11,6C6.43937,6,4.52441,9.675,4.04567,10.8ZM11,13.5C9.61417,13.5,8.480319999999999,12.375,8.480319999999999,11C8.480319999999999,9.625,9.61417,8.5,11,8.5C12.38583,8.5,13.5197,9.625,13.5197,11C13.5197,12.375,12.38583,13.5,11,13.5ZM11,9.5C10.1685,9.5,9.48819,10.175,9.48819,11C9.48819,11.825,10.1685,12.5,11,12.5C11.8315,12.5,12.51181,11.825,12.51181,11C12.51181,10.175,11.8315,9.5,11,9.5Z" stroke-opacity="0" fill-opacity="1"></path></svg>'), KB = () => FB.cloneNode(!0), VB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M5.80417,14.9887L4.62563,16.167299999999997C4.43037,16.3625,4.43037,16.6791,4.62563,16.8744C4.82089,17.0696,5.13748,17.0696,5.332739999999999,16.8744L6.62638,15.5807C7.75595,16.290100000000002,9.19328,16.7929,11,16.7929C16.165399999999998,16.7929,18.3323,12.64289,18.8866,11.36789C19.0378,10.99289,19.0378,10.59289,18.8866,10.21789C18.5549,9.45486,17.6456,7.66212,15.8617,6.34545L17.3536,4.853553C17.5488,4.658291,17.5488,4.341709,17.3536,4.146447C17.1583,3.9511845,16.8417,3.9511845,16.6464,4.146447L15.0014,5.7915399999999995C13.9314,5.1969,12.61166,4.792893,11,4.792893C5.80945,4.792893,3.667717,8.94289,3.113386,10.21789C2.9622049,10.59289,2.9622049,10.99289,3.113386,11.36789C3.424435,12.08333,4.2353000000000005,13.70399,5.80417,14.9887ZM7.36012,14.847C8.32327,15.4074,9.52286,15.7929,11,15.7929C15.5606,15.7929,17.4756,12.11789,17.9543,10.99289C18.0047,10.86789,18.0047,10.74289,17.9543,10.61789C17.659,9.90846,16.8171,8.23812,15.1447,7.06241L12.96929,9.23782C13.3134,9.66543,13.5197,10.20642,13.5197,10.79289C13.5197,12.16789,12.38583,13.29289,11,13.29289C10.41596,13.29289,9.87667,13.09308,9.44815,12.75896L7.36012,14.847ZM8.794609999999999,11.99829L6.520099999999999,14.2728C5.06905,13.12119,4.32057,11.628250000000001,4.04567,10.96789C3.995275,10.84289,3.995275,10.71789,4.04567,10.59289C4.52441,9.46789,6.43937,5.79289,11,5.79289C12.28868,5.79289,13.3661,6.086320000000001,14.2596,6.53329L12.19759,8.5953C11.84086,8.40257,11.43271,8.29289,11,8.29289C9.61417,8.29289,8.480319999999999,9.41789,8.480319999999999,10.79289C8.480319999999999,11.22918,8.594470000000001,11.64029,8.794609999999999,11.99829ZM10.16528,12.04183C10.404869999999999,12.20032,10.692070000000001,12.29289,11,12.29289C11.8315,12.29289,12.51181,11.61789,12.51181,10.79289C12.51181,10.48318,12.41593,10.194600000000001,12.25216,9.95494L10.16528,12.04183ZM11.43602,9.35687L9.55616,11.236740000000001C9.512,11.09633,9.48819,10.94724,9.48819,10.79289C9.48819,9.96789,10.1685,9.29289,11,9.29289C11.15142,9.29289,11.29782,9.31528,11.43602,9.35687Z" stroke-opacity="0" fill-rule="evenodd" fill-opacity="1"></path></svg>'), QB = () => VB.cloneNode(!0), ZB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><defs><clipPath id="master_svg0_151_625"><rect x="0" y="0" width="22" height="22" rx="0"></rect></clipPath></defs><g clip-path="url(#master_svg0_151_625)"><path d="M14.5385,9.76923L15.6538,9.76923C16.6538,9.76923,17.4615,10.576920000000001,17.4615,11.576920000000001L17.4615,17.1923C17.4615,18.1923,16.6538,19,15.6538,19L5.80769,19C4.807692,19,4,18.1923,4,17.1923L4,11.576920000000001C4,10.576920000000001,4.807692,9.76923,5.80769,9.76923L7.23077,9.76923L7.23077,7.576919999999999C7.23077,5.61538,8.88462,4,10.88462,4C12.88462,4,14.5385,5.61538,14.5385,7.576919999999999L14.5385,9.76923ZM10.88461,5.15385C9.5,5.15385,8.38461,6.23077,8.38461,7.576919999999999L8.38461,9.76923L13.38462,9.76923L13.38462,7.576919999999999C13.38462,6.23077,12.26923,5.15385,10.88461,5.15385ZM15.6538,17.8462C16,17.8462,16.3077,17.5385,16.3077,17.1923L16.3077,11.576920000000001C16.3077,11.23077,16,10.923079999999999,15.6538,10.923079999999999L5.80769,10.923079999999999C5.46154,10.923079999999999,5.15385,11.23077,5.15385,11.576920000000001L5.15385,17.1923C5.15385,17.5385,5.46154,17.8462,5.80769,17.8462L15.6538,17.8462ZM10.153839999999999,12.65385C10.153839999999999,12.34615,10.42307,12.07692,10.73076,12.07692C11.038450000000001,12.07692,11.307680000000001,12.34615,11.307680000000001,12.65385L11.307680000000001,14.5769C11.307680000000001,14.8846,11.038450000000001,15.1538,10.73076,15.1538C10.42307,15.1538,10.153839999999999,14.8846,10.153839999999999,14.5769L10.153839999999999,12.65385Z" stroke-opacity="0" fill-rule="evenodd" fill-opacity="1"></path></g></svg>'), HB = () => ZB.cloneNode(!0), YB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><defs><clipPath id="master_svg0_151_620"><rect x="0" y="0" width="22" height="22" rx="0"></rect></clipPath></defs><g clip-path="url(#master_svg0_151_620)"><path d="M8.38461,9.76923L15.6538,9.76923C16.6538,9.76923,17.4615,10.576920000000001,17.4615,11.576920000000001L17.4615,17.1923C17.4615,18.1923,16.6538,19,15.6538,19L5.80769,19C4.807692,19,4,18.1923,4,17.1923L4,11.576920000000001C4,10.576920000000001,4.807693,9.76923,5.80769,9.76923L7.23077,9.76923L7.23077,7.576919999999999C7.23077,5.61538,8.88462,4,10.88462,4C12.46154,4,13.84615,4.961539,14.3462,6.423080000000001C14.4615,6.73077,14.3077,7.038460000000001,14,7.15385C13.69231,7.26923,13.38461,7.11538,13.26923,6.80769C12.92308,5.80769,11.96154,5.15385,10.88462,5.15385C9.5,5.15385,8.38461,6.23077,8.38461,7.576919999999999L8.38461,9.76923ZM15.6538,17.8462C16,17.8462,16.3077,17.5385,16.3077,17.1923L16.3077,11.576920000000001C16.3077,11.23077,16,10.923079999999999,15.6538,10.923079999999999L5.80769,10.923079999999999C5.46154,10.923079999999999,5.15385,11.23077,5.15385,11.576920000000001L5.15385,17.1923C5.15385,17.5385,5.46154,17.8462,5.80769,17.8462L15.6538,17.8462ZM10.153839999999999,12.65385C10.153839999999999,12.34615,10.42307,12.07692,10.73076,12.07692C11.03846,12.07692,11.307690000000001,12.34615,11.307690000000001,12.65385L11.307690000000001,14.5769C11.307690000000001,14.8846,11.03846,15.1538,10.73076,15.1538C10.42307,15.1538,10.153839999999999,14.8846,10.153839999999999,14.5769L10.153839999999999,12.65385Z" stroke-opacity="0" fill-rule="evenodd" fill-opacity="1"></path></g></svg>'), GB = () => YB.cloneNode(!0), JB = /* @__PURE__ */ g('<svg class="icon-overlay" viewBox="0 0 22 22"><path d="M16.966900000000003,8.67144C16.6669,8.67144,16.4247,8.91558,16.4247,9.21802L16.4247,16.631500000000003C16.4247,17.322,16.007199999999997,17.9068,15.5139,17.9068L13.93072,17.9068L13.93072,9.2162C13.93072,8.91741,13.68675,8.67144,13.38855,8.67144C13.09036,8.67144,12.84639,8.91741,12.84639,9.21802L12.84639,17.9068L10.151810000000001,17.9068L10.151810000000001,9.21802C10.151810000000001,8.91741,9.90783,8.67144,9.609639999999999,8.67144C9.31145,8.67144,9.06747,8.91741,9.06747,9.219850000000001L9.06747,17.9068L7.48614,17.9068C6.99277,17.9068,6.5753,17.322,6.5753,16.631500000000003L6.5753,9.21802C6.5753,8.91558,6.333130000000001,8.67144,6.03313,8.67144C5.73313,8.67144,5.49096,8.91558,5.49096,9.21802L5.49096,16.631500000000003C5.49096,17.9378,6.385540000000001,19,7.48614,19L15.512,19C16.6127,19,17.509,17.9378,17.509,16.631500000000003L17.509,9.21802C17.509,8.91558,17.2669,8.67144,16.966900000000003,8.67144ZM18.4578,6.21183L4.542169,6.21183C4.243976,6.21183,4,6.45779,4,6.75841C4,7.05903,4.243976,7.30499,4.542169,7.30499L18.4578,7.30499C18.756,7.30499,19,7.05903,19,6.75841C19,6.45779,18.756,6.21183,18.4578,6.21183ZM8.68072,5.10045L14.3193,5.10045C14.6175,5.10045,14.8614,4.852666,14.8614,4.550225C14.8614,4.247783,14.6175,4,14.3193,4L8.68072,4C8.38253,4,8.13855,4.247783,8.13855,4.550225C8.13855,4.852666,8.38253,5.10045,8.68072,5.10045Z" stroke-opacity="0" fill-opacity="1"></path></svg>'), XB = () => JB.cloneNode(!0), WB = {
  horizontalStraightLine: BI,
  horizontalRayLine: PI,
  horizontalSegment: RI,
  verticalStraightLine: OI,
  verticalRayLine: jI,
  verticalSegment: KI,
  straightLine: QI,
  rayLine: HI,
  segment: GI,
  arrow: XI,
  priceLine: qI,
  priceChannelLine: tB,
  parallelStraightLine: oB,
  fibonacciLine: sB,
  fibonacciSegment: rB,
  fibonacciCircle: lB,
  fibonacciSpiral: dB,
  fibonacciSpeedResistanceFan: $B,
  fibonacciExtension: hB,
  gannBox: pB,
  circle: yB,
  triangle: bB,
  rect: LB,
  parallelogram: wB,
  threeWaves: AB,
  fiveWaves: MB,
  eightWaves: DB,
  anyWaves: BB,
  abcd: PB,
  xabcd: RB,
  weak_magnet: OB,
  strong_magnet: jB,
  lock: HB,
  unlock: GB,
  visible: KB,
  invisible: QB,
  remove: XB
};
function qB(e) {
  return [
    { key: "horizontalStraightLine", text: _("horizontal_straight_line", e) },
    { key: "horizontalRayLine", text: _("horizontal_ray_line", e) },
    { key: "horizontalSegment", text: _("horizontal_segment", e) },
    { key: "verticalStraightLine", text: _("vertical_straight_line", e) },
    { key: "verticalRayLine", text: _("vertical_ray_line", e) },
    { key: "verticalSegment", text: _("vertical_segment", e) },
    { key: "straightLine", text: _("straight_line", e) },
    { key: "rayLine", text: _("ray_line", e) },
    { key: "segment", text: _("segment", e) },
    { key: "arrow", text: _("arrow", e) },
    { key: "priceLine", text: _("price_line", e) }
  ];
}
function eU(e) {
  return [
    { key: "priceChannelLine", text: _("price_channel_line", e) },
    { key: "parallelStraightLine", text: _("parallel_straight_line", e) }
  ];
}
function tU(e) {
  return [
    { key: "circle", text: _("circle", e) },
    { key: "rect", text: _("rect", e) },
    { key: "parallelogram", text: _("parallelogram", e) },
    { key: "triangle", text: _("triangle", e) }
  ];
}
function nU(e) {
  return [
    { key: "fibonacciLine", text: _("fibonacci_line", e) },
    { key: "fibonacciSegment", text: _("fibonacci_segment", e) },
    { key: "fibonacciCircle", text: _("fibonacci_circle", e) },
    { key: "fibonacciSpiral", text: _("fibonacci_spiral", e) },
    { key: "fibonacciSpeedResistanceFan", text: _("fibonacci_speed_resistance_fan", e) },
    { key: "fibonacciExtension", text: _("fibonacci_extension", e) },
    { key: "gannBox", text: _("gann_box", e) }
  ];
}
function oU(e) {
  return [
    { key: "xabcd", text: _("xabcd", e) },
    { key: "abcd", text: _("abcd", e) },
    { key: "threeWaves", text: _("three_waves", e) },
    { key: "fiveWaves", text: _("five_waves", e) },
    { key: "eightWaves", text: _("eight_waves", e) },
    { key: "anyWaves", text: _("any_waves", e) }
  ];
}
function aU(e) {
  return [
    { key: "weak_magnet", text: _("weak_magnet", e) },
    { key: "strong_magnet", text: _("strong_magnet", e) }
  ];
}
const F = (e) => WB[e.name](e.class), sU = /* @__PURE__ */ g('<div class="klinecharts-pro-drawing-bar"><span class="split-line"></span><div class="item" tabindex="0"><span style="width:32px;height:32px"></span><div class="icon-arrow"><svg viewBox="0 0 4 6"><path d="M1.07298,0.159458C0.827521,-0.0531526,0.429553,-0.0531526,0.184094,0.159458C-0.0613648,0.372068,-0.0613648,0.716778,0.184094,0.929388L2.61275,3.03303L0.260362,5.07061C0.0149035,5.28322,0.0149035,5.62793,0.260362,5.84054C0.505822,6.05315,0.903789,6.05315,1.14925,5.84054L3.81591,3.53075C4.01812,3.3556,4.05374,3.0908,3.92279,2.88406C3.93219,2.73496,3.87113,2.58315,3.73964,2.46925L1.07298,0.159458Z" stroke="none" stroke-opacity="0"></path></svg></div></div><div class="item"><span style="width:32px;height:32px"></span></div><div class="item"><span style="width:32px;height:32px"></span></div><span class="split-line"></span><div class="item"><span style="width:32px;height:32px"></span></div></div>'), iU = /* @__PURE__ */ g('<div class="item" tabindex="0"><span style="width:32px;height:32px"></span><div class="icon-arrow"><svg viewBox="0 0 4 6"><path d="M1.07298,0.159458C0.827521,-0.0531526,0.429553,-0.0531526,0.184094,0.159458C-0.0613648,0.372068,-0.0613648,0.716778,0.184094,0.929388L2.61275,3.03303L0.260362,5.07061C0.0149035,5.28322,0.0149035,5.62793,0.260362,5.84054C0.505822,6.05315,0.903789,6.05315,1.14925,5.84054L3.81591,3.53075C4.01812,3.3556,4.05374,3.0908,3.92279,2.88406C3.93219,2.73496,3.87113,2.58315,3.73964,2.46925L1.07298,0.159458Z" stroke="none" stroke-opacity="0"></path></svg></div></div>'), yt = /* @__PURE__ */ g('<li><span style="padding-left:8px"></span></li>'), Ct = "drawing_tools", ln = (e) => {
  const [t, n] = C("horizontalStraightLine"), [o, a] = C("priceChannelLine"), [s, r] = C("circle"), [i, c] = C("fibonacciLine"), [$, l] = C("xabcd"), [h, f] = C("weak_magnet"), [v, D] = C("normal"), [z, U] = C(!1), [M, E] = C(!0), [S, T] = C(""), V = I(() => [{
    key: "singleLine",
    icon: t(),
    list: qB(e.locale),
    setter: n
  }, {
    key: "moreLine",
    icon: o(),
    list: eU(e.locale),
    setter: a
  }, {
    key: "polygon",
    icon: s(),
    list: tU(e.locale),
    setter: r
  }, {
    key: "fibonacci",
    icon: i(),
    list: nU(e.locale),
    setter: c
  }, {
    key: "wave",
    icon: $(),
    list: oU(e.locale),
    setter: l
  }]), le = I(() => aU(e.locale));
  return (() => {
    const te = sU.cloneNode(!0), Ae = te.firstChild, _e = Ae.nextSibling, de = _e.firstChild, Ne = de.nextSibling, c1 = Ne.firstChild, Te = _e.nextSibling, Me = Te.firstChild, ne = Te.nextSibling, Oe = ne.firstChild, l1 = ne.nextSibling, _1 = l1.nextSibling, Ee = _1.firstChild;
    return p(te, () => V().map((L) => (() => {
      const P = iU.cloneNode(!0), K = P.firstChild, q = K.nextSibling, d1 = q.firstChild;
      return P.addEventListener("blur", () => {
        T("");
      }), K.$$click = () => {
        e.onDrawingItemClick({
          groupId: Ct,
          name: L.icon,
          visible: M(),
          lock: z(),
          mode: v()
        });
      }, p(K, m(F, {
        get name() {
          return L.icon;
        }
      })), q.$$click = () => {
        L.key === S() ? T("") : T(L.key);
      }, p(P, (() => {
        const ue = I(() => L.key === S());
        return () => ue() && m(L1, {
          class: "list",
          get children() {
            return L.list.map((Y) => (() => {
              const d = yt.cloneNode(!0), u = d.firstChild;
              return d.$$click = () => {
                L.setter(Y.key), e.onDrawingItemClick({
                  name: Y.key,
                  lock: z(),
                  mode: v()
                }), T("");
              }, p(d, m(F, {
                get name() {
                  return Y.key;
                }
              }), u), p(u, () => Y.text), d;
            })());
          }
        });
      })(), null), O(() => W(d1, "class", L.key === S() ? "rotate" : "")), P;
    })()), Ae), _e.addEventListener("blur", () => {
      T("");
    }), de.$$click = () => {
      let L = h();
      v() !== "normal" && (L = "normal"), D(L), e.onModeChange(L);
    }, p(de, (() => {
      const L = I(() => h() === "weak_magnet");
      return () => L() ? (() => {
        const P = I(() => v() === "weak_magnet");
        return () => P() ? m(F, {
          name: "weak_magnet",
          class: "selected"
        }) : m(F, {
          name: "weak_magnet"
        });
      })() : (() => {
        const P = I(() => v() === "strong_magnet");
        return () => P() ? m(F, {
          name: "strong_magnet",
          class: "selected"
        }) : m(F, {
          name: "strong_magnet"
        });
      })();
    })()), Ne.$$click = () => {
      S() === "mode" ? T("") : T("mode");
    }, p(_e, (() => {
      const L = I(() => S() === "mode");
      return () => L() && m(L1, {
        class: "list",
        get children() {
          return le().map((P) => (() => {
            const K = yt.cloneNode(!0), q = K.firstChild;
            return K.$$click = () => {
              f(P.key), D(P.key), e.onModeChange(P.key), T("");
            }, p(K, m(F, {
              get name() {
                return P.key;
              }
            }), q), p(q, () => P.text), K;
          })());
        }
      });
    })(), null), Me.$$click = () => {
      const L = !z();
      U(L), e.onLockChange(L);
    }, p(Me, (() => {
      const L = I(() => !!z());
      return () => L() ? m(F, {
        name: "lock"
      }) : m(F, {
        name: "unlock"
      });
    })()), Oe.$$click = () => {
      const L = !M();
      E(L), e.onVisibleChange(L);
    }, p(Oe, (() => {
      const L = I(() => !!M());
      return () => L() ? m(F, {
        name: "visible"
      }) : m(F, {
        name: "invisible"
      });
    })()), Ee.$$click = () => {
      e.onRemoveClick(Ct);
    }, p(Ee, m(F, {
      name: "remove"
    })), O(() => W(c1, "class", S() === "mode" ? "rotate" : "")), te;
  })();
};
Z(["click"]);
const bt = /* @__PURE__ */ g('<li class="title"></li>'), vt = /* @__PURE__ */ g('<li class="row"></li>'), rU = (e) => m(Re, {
  get title() {
    return _("indicator", e.locale);
  },
  width: 400,
  get onClose() {
    return e.onClose;
  },
  get children() {
    return m(L1, {
      class: "klinecharts-pro-indicator-modal-list",
      get children() {
        return [(() => {
          const t = bt.cloneNode(!0);
          return p(t, () => _("main_indicator", e.locale)), t;
        })(), I(() => ["MA", "EMA", "SMA", "BOLL", "SAR"].map((t) => {
          const n = e.mainIndicators.includes(t);
          return (() => {
            const o = vt.cloneNode(!0);
            return o.$$click = (a) => {
              e.onMainIndicatorChange({
                name: t,
                paneId: "candle_pane",
                added: !n
              });
            }, p(o, m(ft, {
              checked: n,
              get label() {
                return _(t.toLowerCase(), e.locale);
              }
            })), o;
          })();
        })), (() => {
          const t = bt.cloneNode(!0);
          return p(t, () => _("sub_indicator", e.locale)), t;
        })(), I(() => ["MA", "EMA", "MACD", "BOLL", "KDJ", "RSI", "BIAS", "BRAR", "CCI", "DMI", "CR", "PSY", "DMA", "TRIX", "OBV", "VR", "WR", "MTM", "EMV", "SAR", "SMA", "ROC", "PVT", "BBI", "AO"].map((t) => {
          const n = t in e.subIndicators;
          return (() => {
            const o = vt.cloneNode(!0);
            return o.$$click = (a) => {
              e.onSubIndicatorChange({
                name: t,
                paneId: e.subIndicators[t] ?? "",
                added: !n
              });
            }, p(o, m(ft, {
              checked: n,
              get label() {
                return _(t.toLowerCase(), e.locale);
              }
            })), o;
          })();
        }))];
      }
    });
  }
});
Z(["click"]);
function Lt(e, t) {
  switch (e) {
    case "Etc/UTC":
      return _("utc", t);
    case "Pacific/Honolulu":
      return _("honolulu", t);
    case "America/Juneau":
      return _("juneau", t);
    case "America/Los_Angeles":
      return _("los_angeles", t);
    case "America/Chicago":
      return _("chicago", t);
    case "America/Toronto":
      return _("toronto", t);
    case "America/Sao_Paulo":
      return _("sao_paulo", t);
    case "Europe/London":
      return _("london", t);
    case "Europe/Berlin":
      return _("berlin", t);
    case "Asia/Bahrain":
      return _("bahrain", t);
    case "Asia/Dubai":
      return _("dubai", t);
    case "Asia/Ashkhabad":
      return _("ashkhabad", t);
    case "Asia/Almaty":
      return _("almaty", t);
    case "Asia/Bangkok":
      return _("bangkok", t);
    case "Asia/Shanghai":
      return _("shanghai", t);
    case "Asia/Tokyo":
      return _("tokyo", t);
    case "Australia/Sydney":
      return _("sydney", t);
    case "Pacific/Norfolk":
      return _("norfolk", t);
  }
  return e;
}
function cU(e) {
  return [
    { key: "Etc/UTC", text: _("utc", e) },
    { key: "Pacific/Honolulu", text: _("honolulu", e) },
    { key: "America/Juneau", text: _("juneau", e) },
    { key: "America/Los_Angeles", text: _("los_angeles", e) },
    { key: "America/Chicago", text: _("chicago", e) },
    { key: "America/Toronto", text: _("toronto", e) },
    { key: "America/Sao_Paulo", text: _("sao_paulo", e) },
    { key: "Europe/London", text: _("london", e) },
    { key: "Europe/Berlin", text: _("berlin", e) },
    { key: "Asia/Bahrain", text: _("bahrain", e) },
    { key: "Asia/Dubai", text: _("dubai", e) },
    { key: "Asia/Ashkhabad", text: _("ashkhabad", e) },
    { key: "Asia/Almaty", text: _("almaty", e) },
    { key: "Asia/Bangkok", text: _("bangkok", e) },
    { key: "Asia/Shanghai", text: _("shanghai", e) },
    { key: "Asia/Tokyo", text: _("tokyo", e) },
    { key: "Australia/Sydney", text: _("sydney", e) },
    { key: "Pacific/Norfolk", text: _("norfolk", e) }
  ];
}
const lU = (e) => {
  const [t, n] = C(e.timezone), o = I(() => cU(e.locale));
  return m(Re, {
    get title() {
      return _("timezone", e.locale);
    },
    width: 320,
    get buttons() {
      return [{
        children: _("confirm", e.locale),
        onClick: () => {
          e.onConfirm(t()), e.onClose();
        }
      }];
    },
    get onClose() {
      return e.onClose;
    },
    get children() {
      return m(rn, {
        style: {
          width: "100%",
          "margin-top": "20px"
        },
        get value() {
          return t().text;
        },
        onSelected: (a) => {
          n(a);
        },
        get dataSource() {
          return o();
        }
      });
    }
  });
};
function xt(e) {
  return [
    {
      key: "candle.type",
      text: _("candle_type", e),
      component: "select",
      dataSource: [
        { key: "candle_solid", text: _("candle_solid", e) },
        { key: "candle_stroke", text: _("candle_stroke", e) },
        { key: "candle_up_stroke", text: _("candle_up_stroke", e) },
        { key: "candle_down_stroke", text: _("candle_down_stroke", e) },
        { key: "ohlc", text: _("ohlc", e) },
        { key: "area", text: _("area", e) }
      ]
    },
    {
      key: "candle.priceMark.last.show",
      text: _("last_price_show", e),
      component: "switch"
    },
    {
      key: "candle.priceMark.high.show",
      text: _("high_price_show", e),
      component: "switch"
    },
    {
      key: "candle.priceMark.low.show",
      text: _("low_price_show", e),
      component: "switch"
    },
    {
      key: "indicator.lastValueMark.show",
      text: _("indicator_last_value_show", e),
      component: "switch"
    },
    {
      key: "yAxis.type",
      text: _("price_axis_type", e),
      component: "select",
      dataSource: [
        { key: "normal", text: _("normal", e) },
        { key: "percentage", text: _("percentage", e) },
        { key: "log", text: _("log", e) }
      ]
    },
    {
      key: "yAxis.reverse",
      text: _("reverse_coordinate", e),
      component: "switch"
    },
    {
      key: "grid.show",
      text: _("grid_show", e),
      component: "switch"
    }
  ];
}
const _U = /* @__PURE__ */ g('<div class="klinecharts-pro-setting-modal-content"></div>'), dU = /* @__PURE__ */ g("<span></span>"), uU = (e) => {
  const [t, n] = C(e.currentStyles), [o, a] = C(xt(e.locale));
  J(() => {
    a(xt(e.locale));
  });
  const s = (r, i) => {
    const c = {};
    p1(c, r.key, i);
    const $ = x.clone(t());
    p1($, r.key, i), n($), a(o().map((l) => ({
      ...l
    }))), e.onChange(c);
  };
  return m(Re, {
    get title() {
      return _("setting", e.locale);
    },
    width: 560,
    get buttons() {
      return [{
        children: _("restore_default", e.locale),
        onClick: () => {
          e.onRestoreDefault(o()), e.onClose();
        }
      }];
    },
    get onClose() {
      return e.onClose;
    },
    get children() {
      const r = _U.cloneNode(!0);
      return p(r, m(Qn, {
        get each() {
          return o();
        },
        children: (i) => {
          let c;
          const $ = x.formatValue(t(), i.key);
          switch (i.component) {
            case "select": {
              c = m(rn, {
                style: {
                  width: "120px"
                },
                get value() {
                  return _($, e.locale);
                },
                get dataSource() {
                  return i.dataSource;
                },
                onSelected: (l) => {
                  const h = l.key;
                  s(i, h);
                }
              });
              break;
            }
            case "switch": {
              const l = !!$;
              c = m(K6, {
                open: l,
                onChange: () => {
                  s(i, !l);
                }
              });
              break;
            }
          }
          return [(() => {
            const l = dU.cloneNode(!0);
            return p(l, () => i.text), l;
          })(), c];
        }
      })), r;
    }
  });
}, $U = /* @__PURE__ */ g('<img style="width:500px;margin-top: 20px">'), gU = (e) => m(Re, {
  get title() {
    return _("screenshot", e.locale);
  },
  width: 540,
  get buttons() {
    return [{
      type: "confirm",
      children: _("save", e.locale),
      onClick: () => {
        const t = document.createElement("a");
        t.download = "screenshot", t.href = e.url, document.body.appendChild(t), t.click(), t.remove();
      }
    }];
  },
  get onClose() {
    return e.onClose;
  },
  get children() {
    const t = $U.cloneNode(!0);
    return O(() => W(t, "src", e.url)), t;
  }
}), hU = {
  AO: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 5 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 34 }
  ],
  BIAS: [
    { paramNameKey: "BIAS1", precision: 0, min: 1, styleKey: "lines[0].color" },
    { paramNameKey: "BIAS2", precision: 0, min: 1, styleKey: "lines[1].color" },
    { paramNameKey: "BIAS3", precision: 0, min: 1, styleKey: "lines[2].color" },
    { paramNameKey: "BIAS4", precision: 0, min: 1, styleKey: "lines[3].color" },
    { paramNameKey: "BIAS5", precision: 0, min: 1, styleKey: "lines[4].color" }
  ],
  BOLL: [
    { paramNameKey: "period", precision: 0, min: 1, default: 20 },
    { paramNameKey: "standard_deviation", precision: 2, min: 1, default: 2 }
  ],
  BRAR: [
    { paramNameKey: "period", precision: 0, min: 1, default: 26 }
  ],
  BBI: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 3 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 6 },
    { paramNameKey: "params_3", precision: 0, min: 1, default: 12 },
    { paramNameKey: "params_4", precision: 0, min: 1, default: 24 }
  ],
  CCI: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 20 }
  ],
  CR: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 26 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 10 },
    { paramNameKey: "params_3", precision: 0, min: 1, default: 20 },
    { paramNameKey: "params_4", precision: 0, min: 1, default: 40 },
    { paramNameKey: "params_5", precision: 0, min: 1, default: 60 }
  ],
  DMA: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 10 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 50 },
    { paramNameKey: "params_3", precision: 0, min: 1, default: 10 }
  ],
  DMI: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 14 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 6 }
  ],
  EMV: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 14 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 9 }
  ],
  EMA: [
    { paramNameKey: "EMA1", precision: 0, min: 1, styleKey: "lines[0].color" },
    { paramNameKey: "EMA2", precision: 0, min: 1, styleKey: "lines[1].color" },
    { paramNameKey: "EMA3", precision: 0, min: 1, styleKey: "lines[2].color" },
    { paramNameKey: "EMA4", precision: 0, min: 1, styleKey: "lines[3].color" },
    { paramNameKey: "EMA5", precision: 0, min: 1, styleKey: "lines[4].color" }
  ],
  MTM: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 12 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 6 }
  ],
  MA: [
    { paramNameKey: "MA1", precision: 0, min: 1, styleKey: "lines[0].color" },
    { paramNameKey: "MA2", precision: 0, min: 1, styleKey: "lines[1].color" },
    { paramNameKey: "MA3", precision: 0, min: 1, styleKey: "lines[2].color" },
    { paramNameKey: "MA4", precision: 0, min: 1, styleKey: "lines[3].color" },
    { paramNameKey: "MA5", precision: 0, min: 1, styleKey: "lines[4].color" }
  ],
  MACD: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 12 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 26 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 9 }
  ],
  OBV: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 30 }
  ],
  PVT: [],
  PSY: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 12 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 6 }
  ],
  ROC: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 12 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 6 }
  ],
  RSI: [
    { paramNameKey: "RSI1", precision: 0, min: 1, styleKey: "lines[0].color" },
    { paramNameKey: "RSI2", precision: 0, min: 1, styleKey: "lines[1].color" },
    { paramNameKey: "RSI3", precision: 0, min: 1, styleKey: "lines[2].color" },
    { paramNameKey: "RSI4", precision: 0, min: 1, styleKey: "lines[3].color" },
    { paramNameKey: "RSI5", precision: 0, min: 1, styleKey: "lines[4].color" }
  ],
  SMA: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 12 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 2 }
  ],
  KDJ: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 9 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 3 },
    { paramNameKey: "params_3", precision: 0, min: 1, default: 3 }
  ],
  SAR: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 2 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 2 },
    { paramNameKey: "params_3", precision: 0, min: 1, default: 20 }
  ],
  TRIX: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 12 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 9 }
  ],
  VOL: [
    { paramNameKey: "MA1", precision: 0, min: 1, styleKey: "lines[0].color" },
    { paramNameKey: "MA2", precision: 0, min: 1, styleKey: "lines[1].color" },
    { paramNameKey: "MA3", precision: 0, min: 1, styleKey: "lines[2].color" },
    { paramNameKey: "MA4", precision: 0, min: 1, styleKey: "lines[3].color" },
    { paramNameKey: "MA5", precision: 0, min: 1, styleKey: "lines[4].color" }
  ],
  VR: [
    { paramNameKey: "params_1", precision: 0, min: 1, default: 26 },
    { paramNameKey: "params_2", precision: 0, min: 1, default: 6 }
  ],
  WR: [
    { paramNameKey: "WR1", precision: 0, min: 1, styleKey: "lines[0].color" },
    { paramNameKey: "WR2", precision: 0, min: 1, styleKey: "lines[1].color" },
    { paramNameKey: "WR3", precision: 0, min: 1, styleKey: "lines[2].color" },
    { paramNameKey: "WR4", precision: 0, min: 1, styleKey: "lines[3].color" },
    { paramNameKey: "WR5", precision: 0, min: 1, styleKey: "lines[4].color" }
  ]
}, mU = /* @__PURE__ */ g('<div class="klinecharts-pro-indicator-setting-modal-content"></div>'), pU = /* @__PURE__ */ g("<span></span>"), fU = (e) => {
  const [t, n] = C(x.clone(e.params.calcParams)), o = (a) => hU[a];
  return m(Re, {
    get title() {
      return e.params.indicatorName;
    },
    width: 360,
    get buttons() {
      return [{
        type: "confirm",
        children: _("confirm", e.locale),
        onClick: () => {
          const a = o(e.params.indicatorName), s = [];
          x.clone(t()).forEach((r, i) => {
            !x.isValid(r) || r === "" ? "default" in a[i] && s.push(a[i].default) : s.push(r);
          }), e.onConfirm(s), e.onClose();
        }
      }];
    },
    get onClose() {
      return e.onClose;
    },
    get children() {
      const a = mU.cloneNode(!0);
      return p(a, () => o(e.params.indicatorName).map((s, r) => [(() => {
        const i = pU.cloneNode(!0);
        return p(i, () => _(s.paramNameKey, e.locale)), i;
      })(), m(j6, {
        style: {
          width: "200px"
        },
        get value() {
          return t()[r] ?? "";
        },
        get precision() {
          return s.precision;
        },
        get min() {
          return s.min;
        },
        onChange: (i) => {
          const c = x.clone(t());
          c[r] = i, n(c);
        }
      })])), a;
    }
  });
};
Z(["click"]);
const yU = /* @__PURE__ */ g("<div></div>"), CU = /* @__PURE__ */ g('<div class="klinecharts-pro-content"></div>'), bU = /* @__PURE__ */ g('<div class="klinecharts-pro-content"><div class="klinecharts-pro-widget"></div></div>');
function Qe(e, t, n, o) {
  return t === "VOL" && (o = {
    gap: {
      bottom: 2
    },
    ...o
  }), (e == null ? void 0 : e.createIndicator({
    name: t,
    // @ts-expect-error
    createTooltipDataSource: ({
      indicator: a,
      defaultStyles: s
    }) => {
      const r = [];
      return a.visible ? (r.push(s.tooltip.icons[1]), r.push(s.tooltip.icons[2]), r.push(s.tooltip.icons[3])) : (r.push(s.tooltip.icons[0]), r.push(s.tooltip.icons[2]), r.push(s.tooltip.icons[3])), {
        icons: r
      };
    }
  }, n, o)) ?? null;
}
const vU = (e) => {
  let t, n = null, o, a = !1;
  const [s, r] = C(e.theme), [i, c] = C(e.styles), [$, l] = C(e.locale), [h, f] = C(e.symbol), [v, D] = C(e.period), [z, U] = C(!1), [M, E] = C([...e.mainIndicators]), [S, T] = C({}), [V, le] = C(!1), [te, Ae] = C({
    key: e.timezone,
    text: Lt(e.timezone, e.locale)
  }), [_e, de] = C(!1), [Ne, c1] = C(), [Te, Me] = C(""), [ne, Oe] = C(e.drawingBarVisible), [l1, _1] = C(!1), [Ee, L] = C(!1), [P, K] = C({
    visible: !1,
    indicatorName: "",
    paneId: "",
    calcParams: []
  });
  e.ref({
    setTheme: r,
    getTheme: () => s(),
    setStyles: c,
    getStyles: () => n.getStyles(),
    setLocale: l,
    getLocale: () => $(),
    setTimezone: (d) => {
      Ae({
        key: d,
        text: Lt(e.timezone, $())
      });
    },
    getTimezone: () => te().key,
    setSymbol: f,
    getSymbol: () => h(),
    setPeriod: D,
    getPeriod: () => v(),
    scrollByDistance: (d) => n.scrollByDistance(d),
    resize: () => n.resize(),
    getWidget: () => n
  });
  const q = () => {
    n == null || n.resize();
  }, d1 = (d, u, b) => {
    let y = u, R = y;
    switch (d.timespan) {
      case "minute": {
        y = y - y % (60 * 1e3), R = y - b * d.multiplier * 60 * 1e3;
        break;
      }
      case "hour": {
        y = y - y % (60 * 60 * 1e3), R = y - b * d.multiplier * 60 * 60 * 1e3;
        break;
      }
      case "day": {
        y = y - y % (60 * 60 * 1e3), R = y - b * d.multiplier * 24 * 60 * 60 * 1e3;
        break;
      }
      case "week": {
        const G = new Date(y).getDay(), oe = G === 0 ? 6 : G - 1;
        y = y - oe * 60 * 60 * 24;
        const ge = new Date(y);
        y = new Date(`${ge.getFullYear()}-${ge.getMonth() + 1}-${ge.getDate()}`).getTime(), R = b * d.multiplier * 7 * 24 * 60 * 60 * 1e3;
        break;
      }
      case "month": {
        const $e = new Date(y), G = $e.getFullYear(), oe = $e.getMonth() + 1;
        y = new Date(`${G}-${oe}-01`).getTime(), R = b * d.multiplier * 30 * 24 * 60 * 60 * 1e3;
        const ge = new Date(R);
        R = new Date(`${ge.getFullYear()}-${ge.getMonth() + 1}-01`).getTime();
        break;
      }
      case "year": {
        const G = new Date(y).getFullYear();
        y = new Date(`${G}-01-01`).getTime(), R = b * d.multiplier * 365 * 24 * 60 * 60 * 1e3;
        const oe = new Date(R);
        R = new Date(`${oe.getFullYear()}-01-01`).getTime();
        break;
      }
    }
    return [R, y];
  };
  Tt(() => {
    if (window.addEventListener("resize", q), n = un(t, {
      customApi: {
        formatDate: (d, u, b, y) => {
          switch (v().timespan) {
            case "minute":
              return y === je.XAxis ? x.formatDate(d, u, "HH:mm") : x.formatDate(d, u, "YYYY-MM-DD HH:mm");
            case "hour":
              return y === je.XAxis ? x.formatDate(d, u, "MM-DD HH:mm") : x.formatDate(d, u, "YYYY-MM-DD HH:mm");
            case "day":
            case "week":
              return x.formatDate(d, u, "YYYY-MM-DD");
            case "month":
              return y === je.XAxis ? x.formatDate(d, u, "YYYY-MM") : x.formatDate(d, u, "YYYY-MM-DD");
            case "year":
              return y === je.XAxis ? x.formatDate(d, u, "YYYY") : x.formatDate(d, u, "YYYY-MM-DD");
          }
          return x.formatDate(d, u, "YYYY-MM-DD HH:mm");
        }
      }
    }), n) {
      const d = n.getDom("candle_pane", O1.Main);
      if (d) {
        let b = document.createElement("div");
        if (b.className = "klinecharts-pro-watermark", x.isString(e.watermark)) {
          const y = e.watermark.replace(/(^\s*)|(\s*$)/g, "");
          b.innerHTML = y;
        } else
          b.appendChild(e.watermark);
        d.appendChild(b);
      }
      const u = n.getDom("candle_pane", O1.YAxis);
      o = document.createElement("span"), o.className = "klinecharts-pro-price-unit", u == null || u.appendChild(o);
    }
    M().forEach((d) => {
      Qe(n, d, !0, {
        id: "candle_pane"
      });
    }), e.subIndicators.forEach((d) => {
      const u = Qe(n, d, !0);
      u && (n == null || n.removeIndicator(u, d));
    }), T({}), n == null || n.subscribeAction($n.OnTooltipIconClick, (d) => {
      if (d.indicatorName)
        switch (d.iconId) {
          case "visible": {
            n == null || n.overrideIndicator({
              name: d.indicatorName,
              visible: !0
            }, d.paneId);
            break;
          }
          case "invisible": {
            n == null || n.overrideIndicator({
              name: d.indicatorName,
              visible: !1
            }, d.paneId);
            break;
          }
          case "setting": {
            const u = n == null ? void 0 : n.getIndicatorByPaneId(d.paneId, d.indicatorName);
            K({
              visible: !0,
              indicatorName: d.indicatorName,
              paneId: d.paneId,
              calcParams: u.calcParams
            });
            break;
          }
          case "close":
            if (d.paneId === "candle_pane") {
              const u = [...M()];
              n == null || n.removeIndicator("candle_pane", d.indicatorName), u.splice(u.indexOf(d.indicatorName), 1), E(u);
            } else {
              const u = {
                ...S()
              };
              n == null || n.removeIndicator(d.paneId, d.indicatorName), delete u[d.indicatorName], T(u);
            }
        }
    });
  }), w1(() => {
    window.removeEventListener("resize", q), gn(t);
  }), J(() => {
    const d = h();
    d != null && d.priceCurrency ? (o.innerHTML = d == null ? void 0 : d.priceCurrency.toLocaleUpperCase(), o.style.display = "flex") : o.style.display = "none", n == null || n.setPriceVolumePrecision((d == null ? void 0 : d.pricePrecision) ?? 2, (d == null ? void 0 : d.volumePrecision) ?? 0);
  }), J((d) => {
    if (!a) {
      d && e.datafeed.unsubscribe(d.symbol, d.period);
      const u = h(), b = v();
      return a = !0, L(!0), (async () => {
        const [R, $e] = d1(b, new Date().getTime(), 500), G = await e.datafeed.getHistoryKLineData(u, b, R, $e);
        n == null || n.applyNewData(G, G.length > 0), e.datafeed.subscribe(u, b, (oe) => {
          n == null || n.updateData(oe);
        }), a = !1, L(!1);
      })(), {
        symbol: u,
        period: b
      };
    }
    return d;
  }), J(() => {
    const d = s();
    n == null || n.setStyles(d);
    const u = d === "dark" ? "#929AA5" : "#76808F";
    n == null || n.setStyles({
      indicator: {
        tooltip: {
          icons: [{
            id: "visible",
            position: Fe.Middle,
            marginLeft: 8,
            marginTop: 7,
            marginRight: 0,
            marginBottom: 0,
            paddingLeft: 0,
            paddingTop: 0,
            paddingRight: 0,
            paddingBottom: 0,
            icon: "",
            fontFamily: "icomoon",
            size: 14,
            color: u,
            activeColor: u,
            backgroundColor: "transparent",
            activeBackgroundColor: "rgba(22, 119, 255, 0.15)"
          }, {
            id: "invisible",
            position: Fe.Middle,
            marginLeft: 8,
            marginTop: 7,
            marginRight: 0,
            marginBottom: 0,
            paddingLeft: 0,
            paddingTop: 0,
            paddingRight: 0,
            paddingBottom: 0,
            icon: "",
            fontFamily: "icomoon",
            size: 14,
            color: u,
            activeColor: u,
            backgroundColor: "transparent",
            activeBackgroundColor: "rgba(22, 119, 255, 0.15)"
          }, {
            id: "setting",
            position: Fe.Middle,
            marginLeft: 6,
            marginTop: 7,
            marginBottom: 0,
            marginRight: 0,
            paddingLeft: 0,
            paddingTop: 0,
            paddingRight: 0,
            paddingBottom: 0,
            icon: "",
            fontFamily: "icomoon",
            size: 14,
            color: u,
            activeColor: u,
            backgroundColor: "transparent",
            activeBackgroundColor: "rgba(22, 119, 255, 0.15)"
          }, {
            id: "close",
            position: Fe.Middle,
            marginLeft: 6,
            marginTop: 7,
            marginRight: 0,
            marginBottom: 0,
            paddingLeft: 0,
            paddingTop: 0,
            paddingRight: 0,
            paddingBottom: 0,
            icon: "",
            fontFamily: "icomoon",
            size: 14,
            color: u,
            activeColor: u,
            backgroundColor: "transparent",
            activeBackgroundColor: "rgba(22, 119, 255, 0.15)"
          }]
        }
      }
    });
  }), J(() => {
    n == null || n.setLocale($());
  }), J(() => {
    n == null || n.setTimezone(te().key);
  }), J(() => {
    i() && (n == null || n.setStyles(i()), c1(y6(n.getStyles())));
  });
  let ue;
  if (x.isString(e.header)) {
    if (ue = document.getElementById(e.header), !ue)
      throw new Error("Container is null");
  } else
    ue = e.header;
  We(() => (() => {
    const d = yU.cloneNode(!0);
    return p(d, m(j, {
      get when() {
        return z();
      },
      get children() {
        return m(rU, {
          get locale() {
            return e.locale;
          },
          get mainIndicators() {
            return M();
          },
          get subIndicators() {
            return S();
          },
          onClose: () => {
            U(!1);
          },
          onMainIndicatorChange: (u) => {
            const b = [...M()];
            u.added ? (Qe(n, u.name, !0, {
              id: "candle_pane"
            }), b.push(u.name)) : (n == null || n.removeIndicator("candle_pane", u.name), b.splice(b.indexOf(u.name), 1)), E(b);
          },
          onSubIndicatorChange: (u) => {
            const b = {
              ...S()
            };
            if (u.added) {
              const y = Qe(n, u.name);
              y && (b[u.name] = y);
            } else
              u.paneId && (n == null || n.removeIndicator(u.paneId, u.name), delete b[u.name]);
            T(b);
          }
        });
      }
    }), null), p(d, m(j, {
      get when() {
        return V();
      },
      get children() {
        return m(lU, {
          get locale() {
            return e.locale;
          },
          get timezone() {
            return te();
          },
          onClose: () => {
            le(!1);
          },
          onConfirm: Ae
        });
      }
    }), null), p(d, m(j, {
      get when() {
        return _e();
      },
      get children() {
        return m(uU, {
          get locale() {
            return e.locale;
          },
          get currentStyles() {
            return x.clone(n.getStyles());
          },
          onClose: () => {
            de(!1);
          },
          onChange: (u) => {
            n == null || n.setStyles(u);
          },
          onRestoreDefault: (u) => {
            const b = {};
            u.forEach((y) => {
              const R = y.key;
              p1(b, R, x.formatValue(Ne(), R));
            }), n == null || n.setStyles(b);
          }
        });
      }
    }), null), p(d, m(j, {
      get when() {
        return Te().length > 0;
      },
      get children() {
        return m(gU, {
          get locale() {
            return e.locale;
          },
          get url() {
            return Te();
          },
          onClose: () => {
            Me("");
          }
        });
      }
    }), null), p(d, m(j, {
      get when() {
        return P().visible;
      },
      get children() {
        return m(fU, {
          get locale() {
            return e.locale;
          },
          get params() {
            return P();
          },
          onClose: () => {
            K({
              visible: !1,
              indicatorName: "",
              paneId: "",
              calcParams: []
            });
          },
          onConfirm: (u) => {
            const b = P();
            n == null || n.overrideIndicator({
              name: b.indicatorName,
              calcParams: u
            }, b.paneId);
          }
        });
      }
    }), null), p(d, m(DI, {
      get locale() {
        return e.locale;
      },
      get symbol() {
        return h();
      },
      get spread() {
        return ne();
      },
      get period() {
        return v();
      },
      get periods() {
        return e.periods;
      },
      onMenuClick: async () => {
        try {
          await Rn(() => Oe(!ne())), n == null || n.resize();
        } catch {
        }
      },
      onSymbolClick: () => {
        _1(!l1());
      },
      onPeriodChange: D,
      onIndicatorClick: () => {
        U((u) => !u);
      },
      onTimezoneClick: () => {
        le((u) => !u);
      },
      onSettingClick: () => {
        de((u) => !u);
      },
      onScreenshotClick: () => {
        if (n) {
          const u = n.getConvertPictureUrl(!0, "jpeg", e.theme === "dark" ? "#151517" : "#ffffff");
          Me(u);
        }
      }
    }), null), d;
  })(), ue);
  let Y;
  if (x.isString(e.drawingbar)) {
    if (Y = document.getElementById(e.drawingbar), !Y)
      throw new Error("Container is null");
  } else
    Y = e.drawingbar;
  return We(() => (() => {
    const d = CU.cloneNode(!0);
    return p(d, m(j, {
      get when() {
        return ne();
      },
      get children() {
        return m(ln, {
          get locale() {
            return e.locale;
          },
          onDrawingItemClick: (u) => {
            n == null || n.createOverlay(u);
          },
          onModeChange: (u) => {
            n == null || n.overrideOverlay({
              mode: u
            });
          },
          onLockChange: (u) => {
            n == null || n.overrideOverlay({
              lock: u
            });
          },
          onVisibleChange: (u) => {
            n == null || n.overrideOverlay({
              visible: u
            });
          },
          onRemoveClick: (u) => {
            n == null || n.removeOverlay({
              groupId: u
            });
          }
        });
      }
    })), d;
  })(), Y), (() => {
    const d = bU.cloneNode(!0), u = d.firstChild;
    p(d, m(j, {
      get when() {
        return Ee();
      },
      get children() {
        return m(sn, {});
      }
    }), u);
    const b = t;
    return typeof b == "function" ? A1(b, u) : t = u, O(() => W(u, "data-drawing-bar-visible", ne())), d;
  })();
}, LU = /* @__PURE__ */ g('<svg class="logo" viewBox="0 0 80 92"><path d="M17.3121,90.6225C17.4517,90.6436,17.5901,90.6541,17.7274,90.6541C19.0559,90.6541,20.2213,89.6944,20.4295,88.3532C20.6566,86.8762,19.6297,85.4953,18.1367,85.2705C12.4557,84.4139,8.6332,82.4828,6.77344,79.5289C4.57886,76.0413,5.81634,72.041,5.82344,72.0188C5.85893,71.9123,5.88732,71.8035,5.9098,71.6934C8.12389,60.6361,11.356,53.3215,14.8104,48.1192C18.2648,42.9169,21.9414,39.8269,25.0446,37.2188C26.5968,35.915,28.0614,34.6827,29.2456,33.3731C30.9225,31.5172,31.6197,29.527,31.6725,27.5336C35.6187,26.8278,40.9421,26.2679,47.2065,26.583C48.0984,31.9917,53.6073,36.1009,54.9203,37.0116C62.331,44.1074,67.7577,51.6455,71.0525,59.4213C71.4914,60.4582,72.5065,61.082,73.576,61.082C73.9388,61.082,74.2976,61.01,74.6313,60.8702C76.0249,60.2932,76.6815,58.7074,76.0971,57.3287C72.4887,48.8133,66.5865,40.6151,58.5547,32.9599C58.4423,32.8523,58.3157,32.7516,58.1868,32.665C57.0851,31.9259,54.232,29.5936,53.0642,27.1195C53.1331,27.1287,53.2022,27.138,53.2713,27.1474C54.0162,29.0245,55.8642,30.3535,58.026,30.3535C59.5009,30.3535,60.8298,29.7349,61.7619,28.7456C64.8144,29.7431,68.4378,31.7217,69.4046,35.5848C69.6826,36.6932,70.687,37.4351,71.792,37.4351C71.9884,37.4351,72.1871,37.4117,72.3859,37.3638C73.7062,37.0407,74.5106,35.7206,74.1841,34.4145C72.9993,29.682,69.5399,26.8822,66.0787,25.233C69.5063,23.5492,71.5221,21.2286,71.6702,21.054C72.5457,20.0253,72.412,18.4886,71.3721,17.6226C70.3322,16.7577,68.78,16.8888,67.9033,17.9175C67.87,17.9563,65.4948,20.6901,61.621,21.7153C60.6982,20.8102,59.4281,20.2511,58.026,20.2511C57.4767,20.2511,56.9477,20.3369,56.4519,20.4957C60.0845,17.7606,64.6729,14.2394,65.5797,13.2374C67.1035,11.5533,68.7444,9.07333,67.9103,6.83096C67.4406,5.56933,66.3321,4.73254,64.8675,4.53476C63.5567,4.35687,62.3511,4.77234,61.2899,5.13865C59.4858,5.76127,58.3843,6.06556,56.7564,5.08482C56.1318,4.70797,55.5284,4.32176,54.9369,3.94374L54.9364,3.9434C51.4796,1.73271,47.5602,-0.773825,41.9871,0.726471C40.5296,1.11853,39.6695,2.60604,40.0659,4.04789C40.4622,5.48975,41.9647,6.34058,43.4234,5.94853C46.497,5.12109,48.4668,6.25164,51.9662,8.48933C52.5992,8.89427,53.2439,9.30622,53.9124,9.70882C56.1034,11.0278,58.1028,11.2502,59.7803,11.0758C57.5491,12.857,53.6142,15.8508,49.9988,18.539C49.8498,18.6502,49.7137,18.7754,49.5907,18.9135C48.8054,19.7953,48.2004,20.7386,47.7817,21.7249C40.8791,21.3359,35.0392,21.9433,30.7016,22.7299C28.9691,18.45,25.3757,14.69,23.6876,12.9237L23.2771,12.4919C22.3803,11.5427,21.4493,9.09088,20.724,6.56646C22.9517,7.09896,24.4992,7.27569,26.6784,7.49454C28.182,7.64786,29.5236,6.56295,29.6762,5.07662C29.83,3.59029,28.7357,2.26195,27.2321,2.11098C24.2638,1.81255,22.7731,1.66274,17.8125,0.123747C16.8976,-0.159672,15.8995,0.0512175,15.1814,0.679657C14.4636,1.30796,14.1306,2.26212,14.3036,3.19471C14.6017,4.80159,16.2438,12.9776,19.2819,16.1902L19.7125,16.6431C21.7693,18.7949,24.087,21.4425,25.3073,23.9616C23.5312,24.4607,22.5042,24.8571,22.352,24.9172C21.0897,25.4146,20.4756,26.8272,20.9761,28.076C21.4777,29.3247,22.908,29.9368,24.1703,29.4429C24.1971,29.4326,24.7465,29.2231,25.7556,28.9202C25.6051,29.2154,25.4105,29.4984,25.1676,29.7672C24.2342,30.7995,22.9683,31.8633,21.5025,33.0957C15.0785,38.4945,5.37624,46.647,0.56829,70.5137C0.241766,71.6314,-1.1223,77.1437,2.07787,82.3084C4.80718,86.7136,9.93219,89.5095,17.3121,90.6225ZM31.9158,3.86173C31.9158,5.61208,33.3502,7.03101,35.1195,7.03101C36.8889,7.03101,38.3233,5.61208,38.3233,3.86173C38.3233,2.11139,36.8889,0.69245,35.1195,0.69245C33.3502,0.69245,31.9158,2.11139,31.9158,3.86173ZM76.4249,69.6758C74.6555,69.6758,73.2212,68.2569,73.2212,66.5065C73.2212,64.7562,74.6555,63.3372,76.4249,63.3372C78.1943,63.3372,79.6286,64.7562,79.6286,66.5065C79.6286,68.2569,78.1943,69.6758,76.4249,69.6758ZM33.3378,91.7858C34.2038,91.7987,35.0734,91.8045,35.9465,91.8045C51.0955,91.8046,67.0041,89.9999,69.4317,89.142C76.148,86.7686,80,81.5992,80,74.9575C80,73.463,78.7755,72.2517,77.2648,72.2517C75.754,72.2517,74.5295,73.463,74.5295,74.9575C74.5295,79.3603,72.1953,82.4184,67.6134,84.037C65.7512,84.6175,49.6344,86.6059,33.4183,86.3742C31.9158,86.3297,30.6653,87.5457,30.6428,89.0402C30.6203,90.5359,31.827,91.7636,33.3378,91.7858ZM22.0693,88.8307C22.0693,90.5811,23.5037,92,25.2731,92C27.0424,92,28.4768,90.5811,28.4768,88.8307C28.4768,87.0804,27.0424,85.6615,25.2731,85.6615C23.5037,85.6615,22.0693,87.0804,22.0693,88.8307Z" fill-rule="evenodd" fill-opacity="1"></path><rect x="23.445068359375" y="52.683013916015625" width="12.70588207244873" height="22.702716827392578" rx="2" fill-opacity="1"></rect><path d="M29.562697410583496 47.24264647066593C29.562697410583496 47.11269711728047 29.66804217572163 47.007352352142334 29.797991529107094 47.007352352142334L29.797991529107094 47.007352352142334C29.927940882492557 47.007352352142334 30.03328564763069 47.11269711728047 30.03328564763069 47.24264647066593L30.03328564763069 52.68303155899048C30.03328564763069 52.68303155899048 30.03328564763069 52.68303155899048 30.03328564763069 52.68303155899048L29.562697410583496 52.68303155899048C29.562697410583496 52.68303155899048 29.562697410583496 52.68303155899048 29.562697410583496 52.68303155899048Z" fill-opacity="1"></path><path d="M29.562697410583496 75.38572645187378C29.562697410583496 75.38572645187378 29.562697410583496 75.38572645187378 29.562697410583496 75.38572645187378L30.03328564763069 75.38572645187378C30.03328564763069 75.38572645187378 30.03328564763069 75.38572645187378 30.03328564763069 75.38572645187378L30.03328564763069 80.82611154019833C30.03328564763069 80.95606089358378 29.927940882492557 81.06140565872192 29.797991529107094 81.06140565872192L29.797991529107094 81.06140565872192C29.66804217572163 81.06140565872192 29.562697410583496 80.95606089358378 29.562697410583496 80.82611154019833Z" fill-opacity="1"></path><rect x="42.73918533325195" y="44.73706293106079" width="12.70588207244873" height="22.702716827392578" rx="2" fill-opacity="1"></rect><path d="M48.85681438446045 39.2966954857111C48.85681438446045 39.166746132325635 48.962159149598584 39.0614013671875 49.09210850298405 39.0614013671875L49.09210850298405 39.0614013671875C49.22205785636951 39.0614013671875 49.327402621507645 39.166746132325635 49.327402621507645 39.2966954857111L49.327402621507645 44.737080574035645C49.327402621507645 44.737080574035645 49.327402621507645 44.737080574035645 49.327402621507645 44.737080574035645L48.85681438446045 44.737080574035645C48.85681438446045 44.737080574035645 48.85681438446045 44.737080574035645 48.85681438446045 44.737080574035645Z" fill-opacity="1"></path><path d="M48.85681438446045 67.43977546691895C48.85681438446045 67.43977546691895 48.85681438446045 67.43977546691895 48.85681438446045 67.43977546691895L49.327402621507645 67.43977546691895C49.327402621507645 67.43977546691895 49.327402621507645 67.43977546691895 49.327402621507645 67.43977546691895L49.327402621507645 72.88016055524349C49.327402621507645 73.01010990862895 49.22205785636951 73.11545467376709 49.09210850298405 73.11545467376709L49.09210850298405 73.11545467376709C48.962159149598584 73.11545467376709 48.85681438446045 73.01010990862895 48.85681438446045 72.88016055524349Z" fill-opacity="1"></path></svg>'), xU = LU.cloneNode(!0);
class MU {
  constructor(t) {
    Se(this, "_chartApi", null);
    if (x.isString(t.container)) {
      if (this._container = document.getElementById(t.container), !this._container)
        throw new Error("Container is null");
    } else
      this._container = t.container;
    this._container.classList.add("klinecharts-pro"), this._container.setAttribute("data-theme", t.theme ?? "light");
    const n = this;
    We(() => m(vU, {
      ref: (o) => {
        n._chartApi = o;
      },
      get header() {
        return t.header;
      },
      get drawingbar() {
        return t.drawingbar;
      },
      get styles() {
        return t.styles ?? {};
      },
      get watermark() {
        return t.watermark ?? xU;
      },
      get theme() {
        return t.theme ?? "light";
      },
      get locale() {
        return t.locale ?? "zh-CN";
      },
      get drawingBarVisible() {
        return t.drawingBarVisible ?? !0;
      },
      get symbol() {
        return t.symbol;
      },
      get period() {
        return t.period;
      },
      get periods() {
        return t.periods ?? [{
          multiplier: 1,
          timespan: "minute",
          text: "1m"
        }, {
          multiplier: 5,
          timespan: "minute",
          text: "5m"
        }, {
          multiplier: 15,
          timespan: "minute",
          text: "15m"
        }, {
          multiplier: 1,
          timespan: "hour",
          text: "1H"
        }, {
          multiplier: 2,
          timespan: "hour",
          text: "2H"
        }, {
          multiplier: 4,
          timespan: "hour",
          text: "4H"
        }, {
          multiplier: 1,
          timespan: "day",
          text: "D"
        }, {
          multiplier: 1,
          timespan: "week",
          text: "W"
        }, {
          multiplier: 1,
          timespan: "month",
          text: "M"
        }, {
          multiplier: 1,
          timespan: "year",
          text: "Y"
        }];
      },
      get timezone() {
        return t.timezone ?? "UTC";
      },
      get mainIndicators() {
        return t.mainIndicators ?? [];
      },
      get subIndicators() {
        return t.subIndicators ?? [];
      },
      get datafeed() {
        return t.datafeed;
      }
    }), this._container);
  }
  setTheme(t) {
    var n;
    (n = this._container) == null || n.setAttribute("data-theme", t), this._chartApi.setTheme(t);
  }
  getTheme() {
    return this._chartApi.getTheme();
  }
  setStyles(t) {
    this._chartApi.setStyles(t);
  }
  getStyles() {
    return this._chartApi.getStyles();
  }
  setLocale(t) {
    this._chartApi.setLocale(t);
  }
  getLocale() {
    return this._chartApi.getLocale();
  }
  setTimezone(t) {
    this._chartApi.setTimezone(t);
  }
  getTimezone() {
    return this._chartApi.getTimezone();
  }
  setSymbol(t) {
    this._chartApi.setSymbol(t);
  }
  getSymbol() {
    return this._chartApi.getSymbol();
  }
  setPeriod(t) {
    this._chartApi.setPeriod(t);
  }
  getPeriod() {
    return this._chartApi.getPeriod();
  }
  scrollByDistance(t) {
    return this._chartApi.scrollByDistance(t);
  }
  resize() {
    return this._chartApi.resize();
  }
  getWidget() {
    return this._chartApi.getWidget();
  }
}
class SU {
  constructor(t) {
    if (x.isString(t.container)) {
      if (this._container = document.getElementById(t.container), !this._container)
        throw new Error("Container is null");
    } else
      this._container = t.container;
    this._container.classList.add("klinecharts-pro"), We(() => m(ln, {
      get locale() {
        return t.locale;
      },
      get onDrawingItemClick() {
        return t.onDrawingItemClick;
      },
      get onLockChange() {
        return t.onLockChange;
      },
      get onModeChange() {
        return t.onModeChange;
      },
      get onRemoveClick() {
        return t.onRemoveClick;
      },
      get onVisibleChange() {
        return t.onVisibleChange;
      }
    }), this._container);
  }
}
Bn.forEach((e) => {
  hn(e);
});
export {
  AU as DefaultDatafeed,
  SU as DrawingBarPro,
  MU as KLineChartPro,
  TU as loadLocales
};
