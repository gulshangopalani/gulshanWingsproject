app.controller("Matchresultcntr",["$scope","$http","Dialog","$timeout","sessionService",function(t,e,s,c,n){t.Fancy="MatchOdds",e.get("Geteventcntr/GetSportFrmDatabase").success(function(e,s,c,n){t.sportLst=e.sportData}),t.getResult=function(){e.get("Geteventcntr/GetMatchOddsResult").success(function(e,s,c,n){t.MatchOddsResult=e.MatchOddsResult,t.currentPage=1,t.entryLimit=50,t.filteredItems=t.MatchOddsResult.length,t.totalItems=t.MatchOddsResult.length})},t.getResult(),t.GetMatch=function(s){e.get("Geteventcntr/getMatchLst/"+s.id).success(function(e,s,c,n){t.matchLst=e.matchLst})},t.deleteRecord=function(c,n,a,r,u,o){var d=confirm("Are you sure want to Roll Back Result...");d&&e.get("Geteventcntr/DeleteMatchResult/"+c+"/"+n+"/"+a+"/"+r+"/"+o+"/"+u).success(function(e,c,n,a){s.autohide("Roll Back Successfully"),t.getResult()})},t.GetMarket=function(s,c,a){var r={matchId:s,sportsId:c,user_id:n.get("user_id")};e({method:"POST",url:"Geteventcntr/matchMarketLst/",data:r,headers:{"Content-Type":"application/x-www-form-urlencoded"}}).success(function(e){"fancy"==a?t.getMatchFancy=e.getMatchFancy:t.MatchMarket=e.MatchMarket})},t.Getodds=function(s){e.get("Geteventcntr/get_drpdwnSelectionName/"+s).success(function(e,s,c,n){t.runner=e.runner})},t.saveResult=function(t,e,s,c){alert("MatchOdds")},t.saveMatchoddsResult=function(c,n,a,r,u,o,d,i){var l={Sport_id:n,Match_id:c,market_id:a,selectionId:r,isFancy:1,sportName:u,matchName:o,MarketName:d,selectionName:i};e({method:"POST",url:"Geteventcntr/SetResult/",data:l,headers:{"Content-Type":"application/x-www-form-urlencoded"}}).success(function(e){s.autohide(e.status.message),t.message=e.status.message,t.MatchOddsResult=e.MatchOddsResult,t.currentPage=1,t.entryLimit=50,t.filteredItems=t.MatchOddsResult.length,t.totalItems=t.MatchOddsResult.length})},t.setPage=function(e){t.currentPage=e},t.filter=function(){c(function(){t.filteredItems=t.filtered.length},10)},t.sort_by=function(e){t.predicate=e,t.reverse=!t.reverse}}]),app.filter("startFrom",function(){return function(t,e){return t?(e=+e,t.slice(e)):[]}});