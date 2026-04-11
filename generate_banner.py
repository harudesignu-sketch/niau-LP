"""
Spring Banner Generator
1080×1080px (2K: saved at 2160×2160 @2x)
Child-oriented pop design / 春の無料体験会
"""

from PIL import Image, ImageDraw, ImageFont, ImageFilter
import math, random, os

# Canvas: 2x for 2K quality (will be 2160×2160, displays as 1080×1080 @2x)
W, H = 2160, 2160
FONT_BOLD = '/tmp/fonts/NotoSansCJK-Bold.otf'
FONT_REG  = '/tmp/fonts/NotoSansCJK-Regular.otf'
IPA_FONT  = '/usr/share/fonts/opentype/ipafont-gothic/ipagp.ttf'

# ── Color Palette ──────────────────────────────────────────────
SKY_TOP    = (168, 220, 255)   # bright sky blue top
SKY_BTM    = (220, 245, 255)   # pale sky bottom
BLOSSOM    = (255, 192, 210)   # cherry petal main
BLOSSOM2   = (255, 218, 230)   # cherry petal light
CORAL      = (255, 90, 70)     # title accent (warm red-orange)
CORAL2     = (255, 140, 80)    # subtitle orange
NAVY       = (25,  55, 110)    # main body text
WHITE      = (255, 255, 255)
CREAM      = (255, 252, 240)
MINT       = (100, 210, 170)   # benefit bubble accent
YELLOW     = (255, 225, 50)    # star/sparkle accent
PINK_DARK  = (230, 100, 130)   # dark cherry
LEAF_GREEN = (120, 190,  80)   # spring leaf


def sky_gradient(draw, w, h):
    """Vertical sky gradient background."""
    for y in range(h):
        t = y / h
        r = int(SKY_TOP[0] + t * (SKY_BTM[0] - SKY_TOP[0]))
        g = int(SKY_TOP[1] + t * (SKY_BTM[1] - SKY_TOP[1]))
        b = int(SKY_TOP[2] + t * (SKY_BTM[2] - SKY_TOP[2]))
        draw.line([(0, y), (w, y)], fill=(r, g, b))


def cherry_petal(draw, cx, cy, size, angle=0, color=BLOSSOM, alpha=200):
    """Draw a single cherry blossom petal (heart-like rounded shape)."""
    pts = []
    for i in range(36):
        theta = math.radians(i * 10 + angle)
        r = size * (0.65 + 0.35 * math.cos(2 * theta))
        x = cx + r * math.cos(theta)
        y = cy + r * math.sin(theta)
        pts.append((x, y))
    draw.polygon(pts, fill=(*color, alpha))


def draw_sakura_flower(layer, cx, cy, size, color=BLOSSOM, color2=BLOSSOM2, angle=0):
    """5-petal cherry blossom."""
    for i in range(5):
        pangle = angle + i * 72
        px = cx + size * 0.6 * math.cos(math.radians(pangle))
        py = cy + size * 0.6 * math.sin(math.radians(pangle))
        cherry_petal(layer, px, py, size * 0.45, pangle, color)
    # Center circle
    layer.ellipse([cx - size*0.18, cy - size*0.18,
                   cx + size*0.18, cy + size*0.18], fill=(*YELLOW, 220))


def draw_floating_petals(layer, count=55, seed=42):
    """Scatter petals across canvas."""
    rng = random.Random(seed)
    for _ in range(count):
        x = rng.randint(-80, W + 80)
        y = rng.randint(0, H)
        sz = rng.randint(28, 72)
        ang = rng.randint(0, 360)
        c = rng.choice([BLOSSOM, BLOSSOM2, (255, 180, 200)])
        alpha = rng.randint(120, 210)
        cherry_petal(layer, x, y, sz, ang, c, alpha)


def draw_big_sakura_branches(layer):
    """Large decorative sakura clusters top-left and top-right."""
    # Top-left cluster
    positions_left = [
        (120, 130, 90), (270, 80, 75), (180, 220, 60),
        (380, 160, 70), (60, 280, 55), (330, 280, 50),
    ]
    for cx, cy, sz in positions_left:
        draw_sakura_flower(layer, cx, cy, sz, angle=rng_angle(cx))

    # Top-right cluster
    positions_right = [
        (W-120, 130, 90), (W-270, 80, 75), (W-180, 220, 60),
        (W-380, 160, 70), (W-60, 280, 55), (W-330, 280, 50),
    ]
    for cx, cy, sz in positions_right:
        draw_sakura_flower(layer, cx, cy, sz, angle=rng_angle(cx))

    # Bottom corners
    bottom_left = [(100, H-100, 70), (240, H-60, 55), (60, H-220, 50)]
    for cx, cy, sz in bottom_left:
        draw_sakura_flower(layer, cx, cy, sz, color=BLOSSOM2, angle=rng_angle(cx))
    bottom_right = [(W-100, H-100, 70), (W-240, H-60, 55), (W-60, H-220, 50)]
    for cx, cy, sz in bottom_right:
        draw_sakura_flower(layer, cx, cy, sz, color=BLOSSOM2, angle=rng_angle(cx))


def rng_angle(seed_val):
    return (seed_val * 37) % 360


def draw_sparkles(draw, count=18, seed=7):
    """Draw star sparkles."""
    rng = random.Random(seed)
    for _ in range(count):
        x = rng.randint(100, W - 100)
        y = rng.randint(80, int(H * 0.75))
        sz = rng.randint(10, 28)
        c = rng.choice([YELLOW, WHITE, (255, 255, 200)])
        # 4-pointed star
        pts = []
        for i in range(8):
            a = math.radians(i * 45 - 90)
            r = sz if i % 2 == 0 else sz * 0.4
            pts.append((x + r * math.cos(a), y + r * math.sin(a)))
        draw.polygon(pts, fill=c)


def rounded_rect(draw, x1, y1, x2, y2, radius, fill, outline=None, outline_width=0):
    draw.rounded_rectangle([x1, y1, x2, y2], radius=radius,
                           fill=fill, outline=outline, width=outline_width)


def shadow_text(draw, x, y, text, font, fill, shadow_color=(0,0,0,80), offset=6):
    draw.text((x + offset, y + offset), text, font=font, fill=shadow_color, anchor='mm')
    draw.text((x, y), text, font=font, fill=fill, anchor='mm')


def load_font(size, bold=True):
    try:
        return ImageFont.truetype(FONT_BOLD if bold else FONT_REG, size)
    except Exception:
        return ImageFont.truetype(IPA_FONT, size)


# ── Build the banner ──────────────────────────────────────────
img = Image.new('RGBA', (W, H), (255, 255, 255, 255))

# 1. Sky gradient
bg = Image.new('RGBA', (W, H))
bg_draw = ImageDraw.Draw(bg)
sky_gradient(bg_draw, W, H)
img = Image.alpha_composite(img, bg)

# 2. Floating petals layer (background, subtle)
petal_layer = Image.new('RGBA', (W, H), (0, 0, 0, 0))
petal_draw = ImageDraw.Draw(petal_layer)
draw_floating_petals(petal_draw, count=50)
img = Image.alpha_composite(img, petal_layer.filter(ImageFilter.GaussianBlur(1)))

# 3. Big sakura flowers layer
sakura_layer = Image.new('RGBA', (W, H), (0, 0, 0, 0))
sakura_draw = ImageDraw.Draw(sakura_layer)
draw_big_sakura_branches(sakura_draw)
img = Image.alpha_composite(img, sakura_layer)

# 4. Sparkles
sparkle_layer = Image.new('RGBA', (W, H), (0, 0, 0, 0))
sparkle_draw = ImageDraw.Draw(sparkle_layer)
draw_sparkles(sparkle_draw)
img = Image.alpha_composite(img, sparkle_layer)

# ── Now draw main content ──────────────────────────────────────
draw = ImageDraw.Draw(img)

# ─ ZONE A: Announcement badge ─────────────────────────────────
# Pill badge: "空き枠が出ました｜若干名募集"
badge_y = 380
badge_cx = W // 2
badge_w, badge_h = 960, 108
badge_x1 = badge_cx - badge_w // 2
badge_x2 = badge_cx + badge_w // 2
badge_y1 = badge_y - badge_h // 2
badge_y2 = badge_y + badge_h // 2

# Badge shadow
rounded_rect(draw, badge_x1+8, badge_y1+8, badge_x2+8, badge_y2+8,
             radius=54, fill=(200, 80, 50, 120))
# Badge fill (coral gradient approximation)
rounded_rect(draw, badge_x1, badge_y1, badge_x2, badge_y2,
             radius=54, fill=CORAL2, outline=WHITE, outline_width=6)

font_badge = load_font(56)
draw.text((badge_cx, badge_y), "空き枠が出ました  ｜  若干名募集",
          font=font_badge, fill=WHITE, anchor='mm')

# ─ ZONE B: Main title ─────────────────────────────────────────
title_y = 560
font_title = load_font(148)

# Title shadow + outline effect
for dx, dy in [(-5,-5),(5,-5),(-5,5),(5,5),(0,-6),(0,6),(-6,0),(6,0)]:
    draw.text((W//2 + dx, title_y + dy), "春の無料体験会開催！",
              font=font_title, fill=(220, 60, 50, 180), anchor='mm')
draw.text((W//2, title_y), "春の無料体験会開催！",
          font=font_title, fill=CORAL, anchor='mm')

# ─ ZONE C: Decorative divider ──────────────────────────────────
div_y = 680
for i, c in enumerate([BLOSSOM, PINK_DARK, BLOSSOM, PINK_DARK, BLOSSOM]):
    draw_sakura_flower(sakura_draw, W//2 - 200 + i*100, div_y, 28, color=c)
img = Image.alpha_composite(img, sakura_layer)
draw = ImageDraw.Draw(img)

# ─ ZONE D: Main image placeholder box ─────────────────────────
img_box_y1 = 730
img_box_y2 = 1320
img_box_margin = 180
img_box_x1 = img_box_margin
img_box_x2 = W - img_box_margin

# Box background (cream white card)
rounded_rect(draw, img_box_x1 + 14, img_box_y1 + 14,
             img_box_x2 + 14, img_box_y2 + 14,
             radius=40, fill=(180, 180, 180, 80))
rounded_rect(draw, img_box_x1, img_box_y1, img_box_x2, img_box_y2,
             radius=40, fill=(255, 250, 245, 230), outline=BLOSSOM, outline_width=10)

# Main quote inside box
quote_cx = W // 2
quote_cy = (img_box_y1 + img_box_y2) // 2 - 60
font_quote_main = load_font(118)
font_quote_sub  = load_font(66)

# "失敗していい。" large
draw.text((quote_cx, quote_cy - 60), "失敗していい。",
          font=font_quote_main, fill=NAVY, anchor='mm')
# "だから伸びる。" large, coral
draw.text((quote_cx, quote_cy + 80), "だから伸びる。",
          font=font_quote_main, fill=CORAL, anchor='mm')

# Decorative quotation marks
font_deco = load_font(120)
draw.text((img_box_x1 + 80, img_box_y1 + 60), "❝",
          font=load_font(90, bold=False), fill=(*BLOSSOM, 200), anchor='mm')
draw.text((img_box_x2 - 80, img_box_y2 - 60), "❞",
          font=load_font(90, bold=False), fill=(*BLOSSOM, 200), anchor='mm')

# ─ ZONE E: Benefits pills ─────────────────────────────────────
benefits = [
    ("挑戦できる子になる",   MINT,       NAVY,  "⭐"),
    ("自信が育つ",           CORAL2,     WHITE, "✨"),
    ("定員６名の少人数制",   (80,160,220), WHITE, "🌸"),
]

pill_y_center = 1490
pill_h = 120
pill_gap = 30
total_pw = W - 2 * img_box_margin
each_pw = (total_pw - pill_gap * (len(benefits) - 1)) // len(benefits)

font_benefit = load_font(58)

for i, (text, bg_c, fg_c, icon) in enumerate(benefits):
    px1 = img_box_margin + i * (each_pw + pill_gap)
    px2 = px1 + each_pw
    py1 = pill_y_center - pill_h // 2
    py2 = pill_y_center + pill_h // 2

    # shadow
    rounded_rect(draw, px1+8, py1+8, px2+8, py2+8, radius=pill_h//2,
                 fill=(0, 0, 0, 60))
    rounded_rect(draw, px1, py1, px2, py2, radius=pill_h//2,
                 fill=bg_c, outline=WHITE, outline_width=6)
    draw.text(((px1+px2)//2, pill_y_center),
              f"{icon} {text}", font=font_benefit, fill=fg_c, anchor='mm')

# ─ ZONE F: Central message / tagline ──────────────────────────
tag_y = 1660
font_tagline = load_font(76)
draw.text((W//2, tag_y),
          "子どもたちの「できた！」を一緒に育てます。",
          font=font_tagline, fill=NAVY, anchor='mm')

# ─ ZONE G: Bottom info bar ────────────────────────────────────
bar_y1 = 1760
bar_y2 = H - 100
bar_margin = 80

# Bar shadow
rounded_rect(draw, bar_margin + 12, bar_y1 + 12,
             W - bar_margin + 12, bar_y2 + 12,
             radius=50, fill=(0, 0, 0, 50))

# Bar: white card
rounded_rect(draw, bar_margin, bar_y1, W - bar_margin, bar_y2,
             radius=50, fill=(255, 255, 255, 230))

# Vertical divider
bar_cx = W // 2
draw.line([(bar_cx, bar_y1 + 60), (bar_cx, bar_y2 - 60)],
          fill=(*BLOSSOM, 180), width=4)

# ─ Logo area (left half of bar) ───────────────────────────────
logo_cx = bar_margin + (bar_cx - bar_margin) // 2
logo_cy = (bar_y1 + bar_y2) // 2

font_logo_big   = load_font(96)
font_logo_small = load_font(44, bold=False)
font_logo_ruby  = load_font(38, bold=False)

# Logo circle background
logo_r = 90
draw.ellipse([logo_cx - logo_r, logo_cy - logo_r - 30,
              logo_cx + logo_r, logo_cy + logo_r - 30],
             fill=(*CORAL, 30), outline=CORAL, width=5)

draw.text((logo_cx, logo_cy - 52), "にあう",
          font=font_logo_ruby, fill=CORAL, anchor='mm')
draw.text((logo_cx, logo_cy + 10), "Niau",
          font=font_logo_big, fill=NAVY, anchor='mm')
draw.text((logo_cx, logo_cy + 80), "Men's Hair",
          font=font_logo_small, fill=(100, 120, 150), anchor='mm')

# ─ CTA / Event info (right half of bar) ───────────────────────
cta_cx = bar_cx + (W - bar_margin - bar_cx) // 2
cta_cy = (bar_y1 + bar_y2) // 2

font_cta1 = load_font(62)
font_cta2 = load_font(52, bold=False)

draw.text((cta_cx, cta_cy - 70), "無料体験会",
          font=font_cta1, fill=CORAL, anchor='mm')
draw.text((cta_cx, cta_cy + 10), "お気軽にお問い合わせを",
          font=font_cta2, fill=NAVY, anchor='mm')
draw.text((cta_cx, cta_cy + 80), "Instagram / HP よりご予約",
          font=load_font(46, bold=False), fill=(120, 140, 170), anchor='mm')

# ─ Top banner text (semi-transparent ribbon) ──────────────────
ribbon_y1 = 100
ribbon_y2 = 260
rounded_rect(draw, 120, ribbon_y1, W - 120, ribbon_y2,
             radius=30, fill=(255, 255, 255, 160),
             outline=BLOSSOM, outline_width=6)

font_ribbon = load_font(82)
draw.text((W//2, (ribbon_y1 + ribbon_y2) // 2), "✿  春の特別キャンペーン  ✿",
          font=font_ribbon, fill=PINK_DARK, anchor='mm')

# ─ Edge sakura blossoms (final decorative layer) ──────────────
final_sakura = Image.new('RGBA', (W, H), (0, 0, 0, 0))
fd = ImageDraw.Draw(final_sakura)
extra_flowers = [
    (W//2 - 380, 670, 38, BLOSSOM),
    (W//2 + 380, 670, 38, BLOSSOM),
    (W//2 - 280, 700, 28, BLOSSOM2),
    (W//2 + 280, 700, 28, BLOSSOM2),
    (W//2,       660, 32, BLOSSOM),
]
for cx, cy, sz, c in extra_flowers:
    draw_sakura_flower(fd, cx, cy, sz, color=c)
img = Image.alpha_composite(img, final_sakura)

# ─ Convert to RGB and save ─────────────────────────────────────
out = img.convert('RGB')
os.makedirs('images', exist_ok=True)
out_path = 'images/hinata_spring_banner.png'
out.save(out_path, 'PNG', dpi=(216, 216), optimize=False)
print(f"Saved: {out_path}  ({W}×{H}px @ 216dpi)")

# Also save 1080×1080 version
small = out.resize((1080, 1080), Image.LANCZOS)
small.save('images/hinata_spring_banner_1080.png', 'PNG', dpi=(72, 72))
print(f"Saved: images/hinata_spring_banner_1080.png  (1080×1080px)")
