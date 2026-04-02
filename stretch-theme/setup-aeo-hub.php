<?php
/**
 * WP-CLI script to populate the AEO hub content option.
 * Run via: wp eval-file /var/www/html/wp-content/themes/stretch-theme/setup-aeo-hub.php
 */

$aeo_hub = [
    'headline' => 'Answer Engine Optimization (AEO)',
    'subtitle' => 'The complete guide to getting your content cited by AI-powered search engines like ChatGPT, Gemini, and Perplexity.',
    'intro' => '<p>The search landscape is undergoing its most significant transformation in over two decades. AI-powered answer engines are fundamentally changing how people discover and consume information — and for brands that depend on organic visibility, Answer Engine Optimization isn\'t optional. It\'s existential.</p><p>This hub is your comprehensive resource for understanding and implementing AEO. Each section provides an overview of a critical AEO topic, with links to in-depth guides that go deeper.</p>',
    'sections' => [
        [
            'heading' => 'What Is Answer Engine Optimization?',
            'content' => '<p>Answer Engine Optimization is the practice of structuring your content, brand signals, and digital presence so that AI-powered answer engines cite, reference, and recommend your brand when responding to user queries.</p><p>Unlike traditional SEO, which focuses on ranking in a list of blue links, AEO focuses on becoming the source that AI systems trust and surface in their generated responses. When someone asks ChatGPT or Perplexity a question in your industry, AEO determines whether your brand appears in the answer.</p>',
            'article_slug' => 'what-is-answer-engine-optimization-beginners-guide',
        ],
        [
            'heading' => 'AEO vs Traditional SEO',
            'content' => '<p>While SEO and AEO share common foundations — authoritative content, clear structure, topical depth — they diverge in critical ways. SEO optimizes for ranking position; AEO optimizes for citation probability. SEO targets click-through from search results; AEO targets brand mention in AI-generated answers.</p><p>The most effective content strategies now address both simultaneously. Understanding where they overlap and where they diverge is essential for allocating resources effectively.</p>',
            'article_slug' => 'aeo-vs-seo',
        ],
        [
            'heading' => 'How AI Answer Engines Choose Sources',
            'content' => '<p>AI answer engines use retrieval-augmented generation (RAG) to pull in real-time information when responding to queries. They actively search, evaluate, and synthesize information from multiple sources. The selection process favors content that demonstrates clear expertise, provides definitive answers, and is structured for machine comprehension.</p><p>Understanding this selection process is the foundation of any effective AEO strategy. The brands that appear in AI responses got there because they understand how these systems evaluate and choose sources.</p>',
            'article_slug' => 'how-ai-answer-engines-choose-brands-to-cite',
        ],
        [
            'heading' => 'Structuring Content for AI Engines',
            'content' => '<p>AI models parse content hierarchically. Clear heading structures, concise topic sentences, and definitive statements make your content easier for AI to understand and cite. The inverted pyramid approach — stating your answer first, then providing context — mirrors how AI systems extract and present information.</p><p>Specific formatting patterns, from heading hierarchy to sentence structure, can significantly increase the probability that your content gets cited in AI responses.</p>',
            'article_slug' => 'structure-content-for-ai',
        ],
        [
            'heading' => 'Schema Markup for AEO',
            'content' => '<p>Schema markup provides machine-readable signals that help AI understand the context and relationships within your content. FAQ schema, HowTo schema, Article schema, and Organization schema all play distinct roles in making your content more accessible to AI systems.</p><p>While schema alone won\'t guarantee AI citations, it removes friction from the process and provides the structured data signals that AI systems use to evaluate content relevance and authority.</p>',
            'article_slug' => 'schema-markup-for-aeo-technical-guide',
        ],
        [
            'heading' => 'Building Topical Authority',
            'content' => '<p>AI systems evaluate not just individual pages but your brand\'s overall authority on a topic. The content cluster model — a pillar page supported by comprehensive spoke content — signals to AI that your brand has genuine depth on a subject.</p><p>This hub/spoke architecture creates the internal linking structures and topical coverage that AI systems use to assess whether a source is truly authoritative or merely surface-level.</p>',
            'article_slug' => 'building-topical-authority-content-cluster-strategy-aeo',
        ],
        [
            'heading' => 'Featured Snippets: The Bridge to AEO',
            'content' => '<p>Featured snippets in traditional search remain a critical bridge to AEO success. Content that earns Position Zero demonstrates exactly the qualities that AI answer engines look for: clear structure, definitive answers, and authoritative sourcing.</p><p>Many AI systems also reference the same sources that earn featured snippets, making snippet optimization a two-for-one strategy that serves both traditional SEO and emerging AEO goals.</p>',
            'article_slug' => 'featured-snippets-bridge-to-aeo',
        ],
        [
            'heading' => 'E-E-A-T Signals for AI',
            'content' => '<p>Experience, Expertise, Authoritativeness, and Trustworthiness are not just Google\'s quality guidelines — they\'re the fundamental attributes that AI systems evaluate when choosing sources to cite. Content with clear author credentials, verifiable expertise, and consistent accuracy gets cited more often.</p><p>Practical steps include detailed author bios, linking to credentials, citing reputable sources, and maintaining factual accuracy across your content library.</p>',
            'article_slug' => 'eeat-signals-ai-answer-engines-evaluate',
        ],
        [
            'heading' => 'The Power of Original Research',
            'content' => '<p>AI models heavily favor original data, unique research findings, and proprietary insights. When your content includes statistics, survey results, or analysis that can\'t be found elsewhere, AI systems are more likely to cite your brand as the authoritative source.</p><p>Investing in original research — annual surveys, industry benchmarks, proprietary data analysis — creates a compounding advantage that strengthens your AEO position over time.</p>',
            'article_slug' => 'original-research-data-aeo-competitive-advantage',
        ],
        [
            'heading' => 'Measuring AEO Success',
            'content' => '<p>Traditional metrics like rankings and traffic remain important, but AEO introduces new dimensions: AI citation frequency, brand mention sentiment in AI responses, and share of voice in AI-generated answers for your target topics.</p><p>Forward-thinking brands are building dashboards that combine traditional SEO metrics with AEO-specific measurements to get a complete picture of their organic visibility across both traditional and AI-powered search.</p>',
            'article_slug' => 'measuring-aeo-success-metrics-tools-reporting',
        ],
    ],
];

update_option('stretch_hub_aeo', $aeo_hub, false);

echo "AEO hub content saved to option: stretch_hub_aeo\n";
echo "Sections: " . count($aeo_hub['sections']) . "\n";
