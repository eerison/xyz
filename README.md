[![Continuous Integration](https://github.com/eerison/xyz/actions/workflows/ci.yml/badge.svg)](https://github.com/eerison/xyz/actions/workflows/ci.yml)

# How start?

just run the command bellow

```shell
make up
```

> **Note**
> For "make up" works you need to have installed in your machine [docker](https://www.docker.com/), [docker-composer](https://docs.docker.com/compose/) and [make](https://makefile.site/)

After the setup finish you can see the api on http://localhost:8003/api

# Requirements

- [x] Most expensive and cheapest beer per litre.
  - [x] expensive: http://localhost:8003/api/products?itemsPerPage=1&order[articles.pricePerUnit]=desc
  - [x] cheapest: http://localhost:8003/api/products?itemsPerPage=1&order[articles.pricePerUnit]=asc
- [x] Which beers cost exactly €17.99?: http://localhost:8003/api/products?articles.price=17.99
- [x] Order the result by price per litre (cheapest first): http://localhost:8003/api/products?order[articles.price]=asc
- [ ] Which one product comes in the most bottles?

