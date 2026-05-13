import asyncio, sys
from pathlib import Path
from playwright.async_api import async_playwright
from PIL import Image

TARGETS = [
    {"url": "https://funnelcockpit.com/", "out": "homepage"},
    {"url": "https://funnelcockpit.com/preise/", "out": "pricing"},
    {"url": "https://funnelcockpit.com/funktionen/", "out": "features"},
]
OUT_DIR = Path(sys.argv[1] if len(sys.argv) > 1 else "./images")
OUT_DIR.mkdir(parents=True, exist_ok=True)

async def capture(page, url, out_stem):
    await page.goto(url, wait_until="networkidle", timeout=45000)
    await page.wait_for_timeout(2500)
    # Dismiss cookie banners
    for selector in ["text=Alle akzeptieren", "text=Akzeptieren", "text=Accept", "text=Zustimmen", "[id*=cookie] button", ".cookie-accept"]:
        try:
            await page.click(selector, timeout=2000)
            await page.wait_for_timeout(500)
            break
        except:
            pass
    png_path = OUT_DIR / f"{out_stem}.png"
    await page.screenshot(path=str(png_path), full_page=False)
    img = Image.open(png_path)
    img.save(OUT_DIR / f"{out_stem}.webp", "WEBP", quality=85, method=6)
    png_path.unlink()
    print(f"OK  {out_stem}")

async def main():
    async with async_playwright() as p:
        browser = await p.chromium.launch(headless=True)
        ctx = await browser.new_context(
            viewport={"width": 1440, "height": 900},
            device_scale_factor=1,
            user_agent="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36",
        )
        page = await ctx.new_page()
        for t in TARGETS:
            try:
                await capture(page, t["url"], t["out"])
            except Exception as e:
                print(f"ERR {t['out']}: {e}")
        await browser.close()

asyncio.run(main())
