
                function openCustomSize(PageURL, Width, Height, ToolBar, Location, StatusBar, MenuBar, Resizeable, ScrollBars)
                    {
                        if (Width > 0 && Height > 0) {
                            var setTop = (screen.height - Height) / 2;
                            var setLeft = (screen.width - Width) / 2;
                            var siteOpen = 'width='+Width+', height='+Height+', left='+setLeft+', top='+setTop+', ';
                        }
                        else {
                            //var siteOpen = 'fullscreen=yes, ';
                             var siteOpen = 'width='+window.screen.availWidth+', height='+window.screen.availHeight+', left=0, top=0, ';
                        }
                        var siteOption = siteOpen+'toolbar='+ToolBar+', location='+Location+', status='+StatusBar+', menubar='+MenuBar+', resizable='+Resizeable+', scrollbars='+ScrollBars;
                        SiteWindow = window.open(PageURL , "_blank", ""+siteOption+"");
                    }
        