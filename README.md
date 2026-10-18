# PAH FAQ Schema Generator

A free, browser-based **FAQ schema generator** that turns questions and answers into valid `FAQPage` JSON-LD structured data.

**Live tool:** [FAQ Schema Generator on Pro Articles Hub](https://proarticleshub.com/faq-schema-generator/)

This repository contains the WordPress version of the tool, packaged as a single-file plugin that adds a shortcode.

## Features

- Add, remove and reorder question and answer pairs
- Generates `FAQPage` JSON-LD following schema.org
- Optional `<script type="application/ld+json">` wrapper
- Pretty-print or minified output
- One-click copy
- Warnings for empty, duplicate, too-short or unanswered items
- Escapes `</` so the output is safe to paste inside a script tag
- Runs entirely in the browser: no data is sent to any server

## Installation (WordPress)

1. Download `pah-faq-schema-generator.php`.
2. Upload it to `wp-content/plugins/` (or zip it and use **Plugins > Add New > Upload Plugin**).
3. Activate **PAH FAQ Schema Generator**.
4. Add this shortcode to any page or post:

```
[pah_faq_schema_generator]
```

You can also paste the code (without the plugin header) into a code snippets plugin.

## Example output

```json
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is FAQ schema?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "FAQ schema is structured data that marks up a list of questions and answers on a page."
      }
    }
  ]
}
```

## Important notes

- Only mark up questions and answers that are **visible on the page**.
- Google now shows FAQ rich results only for a limited set of well-known government and health sites, but valid FAQ markup still helps search engines and AI tools understand your content.
- Test the output with the [Rich Results Test](https://search.google.com/test/rich-results) or the [Schema Markup Validator](https://validator.schema.org/).

## More free SEO tools

This tool is part of a collection of [free online SEO tools](https://proarticleshub.com/free-online-seo-tools/) by Pro Articles Hub, including a [broken link checker](https://proarticleshub.com/broken-link-checker/), [meta SEO audit tool](https://proarticleshub.com/meta-seo-audit-tool/) and [llms.txt generator](https://proarticleshub.com/llms-txt-generator/).

## Author

**Kamran Liaquat Ali** – .NET developer and founder of [Pro Articles Hub](https://proarticleshub.com/).
[LinkedIn](https://www.linkedin.com/in/kamranliaquatali)

## License

MIT
